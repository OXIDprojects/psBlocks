<?php
/**
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 * 
 * @copyright (c) Proud Sourcing GmbH | 2013
 * @link www.proudcommerce.com
 * @package psCmsSnippets
 * @version 1.0.0
**/
class psblocks_oxtplblocks_editor extends oxAdminDetails
{

    /**
     * Loads blocks info, passes it to Smarty engine and
     * returns name of template file "psblocks_oxtplblocks_main.tpl".
     *
     * @return string
     */
    public function render()
    {
        $myConfig = $this->getConfig();
        $mySession = $this->getSession();

        $soxId = oxConfig::getParameter( "oxid");
        // check if we right now saved a new entry
        $sSavedID = oxConfig::getParameter( "saved_oxid");
        if ( ($soxId == "-1" || !isset( $soxId)) && isset( $sSavedID) ) {
            $soxId = $sSavedID;
            oxSession::deleteVar( "saved_oxid");
            #$this->_aViewData["oxid"] =  $soxId;
            // for reloading upper frame
            $this->_aViewData["updatelist"] =  "1";
        }

        if ( $soxId != "-1" && isset( $soxId)) {
            // load object
            $oConfi = oxNew( "psblocks_oxtplblocks" );
            $oConfi->load($soxId);

            $this->_aViewData["oxid"] =  $soxId;
            $this->_aViewData["edit"] =  $oConfi;
        }

        return "psblocks_oxtplblocks_editor.tpl";
    }

    /**
     * Saves blocks
     *
     * @return mixed
     */
    public function save()
    {
        $myConfig  = $this->getConfig();

        $soxId   = oxConfig::getParameter( "oxid");
        $aParams = oxConfig::getParameter( "editval");

        $oConfi = oxNew( "psblocks_oxtplblocks" );
        if ( $soxId != "-1" ) {
            $oConfi->load( $soxId );
            $oConfi->assign($aParams);
        } else {
            $aParams['oxtplblocks__oxid']   = null;
        }

        $oConfi->save();

        // set oxid if inserted
        if ( $soxId == "-1") {
            oxSession::setVar( "saved_oxid", $oConfi->getId() );
        }

        $this->_aViewData["updatelist"] = "1";
    }
}