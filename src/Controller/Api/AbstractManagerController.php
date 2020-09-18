<?php
declare(strict_types=1);

namespace App\Controller\Api;

use App\Controller\AbstractManagerController as BaseManagerController;
use App\Util\Common\SafelyArrayJsonEncoder;

abstract class AbstractManagerController extends BaseManagerController
{
    private SafelyArrayJsonEncoder $safelyArrayJsonEncoder;

    public function __construct()
    {
        $this->safelyArrayJsonEncoder = new SafelyArrayJsonEncoder();
    }

    protected function safelyArrayJsonEncode(array $subject, int $options = 0, int $depth = 512): string
    {
        return $this->safelyArrayJsonEncoder->encode($subject, $options, $depth);
    }
}