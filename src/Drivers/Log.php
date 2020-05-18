<?php
/**
 * Author:  CodeSinging (The code is singing)
 * Email:   codesinging@gmail.com
 * Github:  https://github.com/codesinging
 * Time:    2020-05-18 21:13:30
 */

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