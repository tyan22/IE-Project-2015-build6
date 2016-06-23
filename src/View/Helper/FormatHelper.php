<?php
namespace App\View\Helper;

use Cake\View\Helper;

class FormatHelper extends Helper
{
    function orderType($orderType)
    {
        if (($orderType == "R") || ($orderType == "r"))
        {
            return "Repair";
        }
        else if (($orderType == "S") || ($orderType == "s"))
        {
            return "Custom";
        }
        else
            return "Not set";
    }

    function stashVis($vis)
    {
        if (($vis == "Y") || ($vis == "y"))
        {
            return "Public";
        }
        else
        {
            return "Private";
        }

    }

    function formatDate($date)
    {
        return date('d-M-Y', strtotime(($date)));
    }

    function formatPickerDate($date)
    {

        return date('d-m-Y', strtotime(($date)));
    }

    function formatDateTime($date)
    {
        return date('d-M-Y g:i a', strtotime(($date)));
    }


}
?>
