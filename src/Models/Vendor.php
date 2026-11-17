<?php

namespace JeffersonGoncalves\LgpdVendors\Models;

use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use JeffersonGoncalves\LgpdVendors\Enums\TransferMechanism;
use JeffersonGoncalves\LgpdVendors\Enums\VendorIssue;
use JeffersonGoncalves\LgpdVendors\Enums\VendorRisk;
use JeffersonGoncalves\LgpdVendors\Enums\VendorRole;

/**
 * A third party you share personal data with: processor (operador) or controller.
 *
 * @property string $name
 * @property string|null $document CNPJ or foreign registration
 * @property VendorRole $role
 * @property string|null $services
 * @property list<string>|null $data_categories
 * @property string $country ISO 3166-1 alpha-2
 * @property TransferMechanism|null $transfer_mechanism
 * @property VendorRisk $risk
 * @property Carbon|null $dpa_signed_at
 * @property Carbon|null $dpa_expires_at
 * @property array<string, bool>|null $dpa_checklist
 * @property string|null $contact
 * @property Carbon|null $reviewed_at
 * @property Carbon|null $terminated_at
 * @property Carbon|null $data_returned_at
 * @property Carbon $created_at
 */
class Vendor extends Model
{
    protected $guarded = [];

    protected $attributes = [
        'country' => 'BR',
        'risk' => 'medium',
    ];

    public function getTable(): string
    {
        return config('lgpd-vendors.table', 'lgpd_vendors');
    }

    protected function casts(): array
    {
        return [
            'role' => VendorRole::class,
            'risk' => VendorRisk::class,
            'transfer_mechanism' => TransferMechanism::class,
            'data_categories' => 'array',
            'dpa_checklist' => 'array',
            'dpa_signed_at' => 'date',
            'dpa_expires_at' => 'date',
            'reviewed_at' => 'datetime',
            'terminated_at' => 'datetime',
            'data_returned_at' => 'datetime',
        ];
    }

    /**
     * Gaps to fix. An ended relationship only owes the confirmation that the data was deleted or returned.
     *
     * @return list<VendorIssue>
     */
    public function issues(): array
    {
        if ($this->terminated_at !== null) {
            return $this->data_returned_at === null ? [VendorIssue::DataReturnPending] : [];
        }

        $issues = [];

        if ($this->role->needsAgreement()) {
            if ($this->dpa_signed_at === null) {
                $issues[] = VendorIssue::AgreementMissing;
            } elseif ($this->dpa_expires_at?->isPast()) {
                $issues[] = VendorIssue::AgreementExpired;
            }

            if ($this->dpa_signed_at !== null && $this->missingChecklistItems() !== []) {
                $issues[] = VendorIssue::AgreementIncomplete;
            }
        }

        if ($this->isAbroad() && $this->transfer_mechanism === null) {
            $issues[] = VendorIssue::TransferMechanismMissing;
        }

        if ($this->nextReviewAt()->isPast()) {
            $issues[] = VendorIssue::ReviewDue;
        }

        return $issues;
    }

    /**
     * @return list<string> checklist keys from config('lgpd-vendors.dpa_checklist') not ticked yet
     */
    public function missingChecklistItems(): array
    {
        $ticked = $this->dpa_checklist ?? [];

        return array_values(array_filter(
            array_keys((array) config('lgpd-vendors.dpa_checklist', [])),
            fn (string $item): bool => ($ticked[$item] ?? false) !== true,
        ));
    }

    public function isAbroad(): bool
    {
        return strtoupper($this->country) !== strtoupper((string) config('lgpd-vendors.home_country', 'BR'));
    }

    public function nextReviewAt(): Carbon
    {
        $every = (string) (config('lgpd-vendors.review_every')[$this->risk->value] ?? '1 year');

        return ($this->reviewed_at ?? $this->created_at)->copy()->add(CarbonInterval::make($every));
    }

    public function markReviewed(): static
    {
        $this->forceFill(['reviewed_at' => now()])->save();

        return $this;
    }

    public function terminate(): static
    {
        $this->forceFill(['terminated_at' => now()])->save();

        return $this;
    }

    public function confirmDataReturned(): static
    {
        $this->forceFill(['data_returned_at' => now()])->save();

        return $this;
    }

    /**
     * @param  Builder<self>  $query
     */
    public function scopeActive(Builder $query): void
    {
        $query->whereNull('terminated_at');
    }
}
