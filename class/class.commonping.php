<?php
// This Weblog_Commonping Class is originated in http://www.speciii.com/item/296.html .
require_once sprintf('%s/modules/%s/include/PEAR/XML/RPC.php', XOOPS_ROOT_PATH, $xoopsModule->dirname());
require_once sprintf('%s/modules/%s/include/encode_set.inc.php', XOOPS_ROOT_PATH, $xoopsModule->dirname());

class Weblog_Commonping
{
    public $Commonping_Target           = '';
    public $Commonping_Servers          = [];
    public $Commonping_Servers_Response = [];
    public $Ping_XML;    // XML_RPC_Message object
    public $Server_Response;    // XML_RPC_Response object

    // contructor
    public function __construct($siteName, $siteURL)
    {
        // Create XML
        $siteName = encoding_set($siteName, 'UTF-8');

        $params         = [
            new XML_RPC_Value($siteName, 'string'),
            new XML_RPC_Value($siteURL, 'string')
        ];
        $this->Ping_XML = new XML_RPC_Message('weblogUpdates.ping', $params);
    }

    // set target
    public function set_commonping_target($pingTargetURL)
    {
        $check_url = parse_url($pingTargetURL);
        if ('http' !== $check_url['scheme'] || !$check_url['host']) {
            return false;
        } else {
            $this->Commonping_Target = $pingTargetURL;

            return true;
        }
    }

    // send ping
    public function sendPing()
    {
        if (!$this->Commonping_Target) {
            return false;
        }
        // parse URL
        $parsedURL = parse_url($this->Commonping_Target);
        // send ping
        $client                = new XML_RPC_Client($parsedURL['path'], $parsedURL['host'], 80);
        $this->Server_Response = $client->send($this->Ping_XML);

        // result
        if (get_class($this->Server_Response) == strtolower('XML_RPC_Response')
            && false === $this->Server_Response->faultCode()) {
            return true;
        } else {
            return false;
        }
    }

    // return XML_RPC_Response object
    public function getResponse()
    {
        return $this->Server_Response;
    }

    // sammury response code you can get more information through $this->getResponse()
    public function getResultMessage()
    {
        if (false === is_a($this->Server_Response, 'XML_RPC_Response')) {
            return '';
        }

        if (false === $this->Server_Response->faultCode()) {
            return "Success. Response: '" . $this->Server_Response->serialize() . "'";
        } else {
            return 'Failed. Code: ' . $this->Server_Response->faultCode() . " Reason: '" . $this->Server_Response->faultString() . "'";
        }
    }

    public function set_commonping_servers($commonping_server_list_file)
    {
        // set server list from "language/%s/common_ping_servers.inc.php"
        if ($file_line = @file($commonping_server_list_file)) {
            foreach ($file_line as $server_url) {
                $server_url = trim($server_url);
                if ($server_url && !preg_match("/^#.+$/", $server_url)) {
                    array_push($this->Commonping_Servers, $server_url);
                }
            }

            return true;
        } else {
            return false;
        }
    }

    // main
    public function sendPing_all()
    {
        if (is_array($this->Commonping_Servers) && count($this->Commonping_Servers) >= 1) {
            foreach ($this->Commonping_Servers as $ping_server) {
                // read commonping servers from file
                if ($this->set_commonping_target($ping_server)) {
                    // send ping
                    if ($this->sendPing()) {
                        $this->Commonping_Servers_Response[$ping_server] = true;
                    } else {
                        $this->Commonping_Servers_Response[$ping_server] = false;
                    }
                } else {
                    $this->Commonping_Servers_Response[$ping_server] = false;
                }
            }
        }
    }

    // For Xoops - Weblog
    public function xoops_weblog_commonping_process($commonping_server_file)
    {
        $common_ping_result_msg = '';
        if ($this->set_commonping_servers($commonping_server_file)) {
            $this->sendPing_all();
            foreach ($this->Commonping_Servers_Response as $server => $result) {
                if ($result) {
                    $common_ping_result_msg .= $server . '=&gt;' . "success<br>\n";
                } else {
                    $common_ping_result_msg .= $server . '=&gt;' . "failed<br>\n";
                }
            }
        } else {
            $common_ping_result_msg = "Can't open Commonping Sever FILE. <b>\" " . $commonping_server_file . "\"</b>";
        }

        return $common_ping_result_msg;
    }
}
