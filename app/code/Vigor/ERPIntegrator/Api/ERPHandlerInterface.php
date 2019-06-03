<?php
/**
 * @author Ahmed El-Araby <araby2305@gmail.com>
 */
namespace Vigor\ERPIntegrator\Api;

interface ERPHandlerInterface
{
    public function handle(array $data);
}