<?php

return [

    'table' => 'lgpd_vendors',

    /*
     * What a data processing agreement should cover. Keys are stored on each vendor's
     * dpa_checklist; a processor (or joint controller) with an unchecked item is flagged.
     */
    'dpa_checklist' => [
        'instructions' => 'Processes personal data only on the controller\'s documented instructions (art. 39)',
        'confidentiality' => 'People who handle the data are bound to confidentiality',
        'security_measures' => 'Technical and administrative security measures (art. 46)',
        'sub_processors' => 'Sub-processors only with prior authorization and the same obligations',
        'data_subject_rights' => 'Assists the controller with data subject requests (art. 18)',
        'incident_notification' => 'Notifies the controller of security incidents without delay (art. 48)',
        'international_transfers' => 'International transfers only under an art. 33 mechanism',
        'deletion_on_termination' => 'Deletes or returns the data when the contract ends (art. 16)',
        'audits' => 'Allows audits and provides the information needed to prove compliance',
    ],

    /*
     * How often each risk tier must be reviewed, counted from the last review
     * (or from registration). CarbonInterval strings.
     */
    'review_every' => [
        'low' => '3 years',
        'medium' => '2 years',
        'high' => '1 year',
    ],

    /*
     * Your own country: vendors elsewhere need an international transfer mechanism.
     */
    'home_country' => 'BR',

];
