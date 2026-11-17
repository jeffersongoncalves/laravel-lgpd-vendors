<?php

namespace JeffersonGoncalves\LgpdVendors\Enums;

/**
 * Grounds for an international transfer (LGPD art. 33; Res. CD/ANPD 19/2024 for the clauses).
 */
enum TransferMechanism: string
{
    case Adequacy = 'adequacy';                                // I
    case SpecificClauses = 'specific_clauses';                 // II, a
    case StandardClauses = 'standard_clauses';                 // II, b
    case BindingCorporateRules = 'binding_corporate_rules';    // II, c
    case SealsCertificates = 'seals_certificates';             // II, d
    case InternationalCooperation = 'international_cooperation'; // III
    case LifeProtection = 'life_protection';                   // IV
    case AnpdAuthorization = 'anpd_authorization';             // V
    case InternationalCommitment = 'international_commitment'; // VI
    case PublicPolicy = 'public_policy';                       // VII
    case SpecificConsent = 'specific_consent';                 // VIII
    case LegalBasis = 'legal_basis';                           // IX (art. 7, II, V or VI)
}
