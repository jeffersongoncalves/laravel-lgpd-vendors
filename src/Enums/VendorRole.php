<?php

namespace JeffersonGoncalves\LgpdVendors\Enums;

enum VendorRole: string
{
    /** Operador: processes on your behalf (art. 5, VII). Needs a DPA. */
    case Processor = 'processor';

    /** Controlador independente: decides on its own purposes (art. 5, VI). */
    case Controller = 'controller';

    /** Controladoria conjunta: decides purposes together with you. Needs an arrangement. */
    case JointController = 'joint_controller';

    public function needsAgreement(): bool
    {
        return $this !== self::Controller;
    }
}
