<?php


namespace CodeSinging\ThinkSae\Drivers;


use think\contract\LogHandlerInterface;

class Log implements LogHandlerInterface
{
    public function save(array $log): bool
    {

        if (!empty($log)) {
            $info = '<TpLog>';
            foreach ($log as $type => $val) {
                foreach ($val as $msg) {
                    if (!is_string($msg)) {
                        $msg = var_export($msg, true);
                    }
                    $info .= '[' . $type . ']' . $msg ;
                }
            }
            $info .= '</TpLog>';
            sae_debug($info);

            return true;
        }

        return false;

    }
}