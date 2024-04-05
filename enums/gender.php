<?php

abstract class Gender
{
    const Male = 1;
    const Female = 2;
    const Other = 3;

    public static function toString($value)
    {
        switch ($value) {
            case self::Male:
                return "Male";
            case self::Female:
                return "Female";
            case self::Other:
                return "Other";
            default:
                return "Unknown value";
        }
    }
}

?>