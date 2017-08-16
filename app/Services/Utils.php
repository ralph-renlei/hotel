<?php
namespace WxHotel\Services;

class Utils{

    public static function base64ToImg($raw){
        $url = '';
        $data = str_replace(array('data:','base64,'),'',$raw);
        $data_param = explode(';',$data);
        $file_name = date('YmdHis');
        switch(strtolower($data_param[0])){
            case 'image/jpeg':
            case 'image/jpg':
            case 'image/pjpeg':
            default:
                $file_name = date('YmdHis').'.jpg';
            break;
            case 'image/png':
            case 'image/x-png':
                $file_name = date('YmdHis').'.png';
                break;
            case 'image/gif':
                $file_name = date('YmdHis').'.gif';
                break;
            case 'image/bmp':
            case 'image/x-bmp':
            case 'image/x-bitmap':
            case 'image/x-xbitmap':
            $file_name = date('YmdHis').'.bmp';
            break;
        }
        $path = public_path().DIRECTORY_SEPARATOR.'images'.DIRECTORY_SEPARATOR.$file_name;
        file_put_contents($path,base64_decode($data_param[1]));
        $url = url('images/'.$file_name);
        return $url;
    }

    /**
     * 将数据转为XML
     */
    public static function toXml($array){
        $xml = '<xml>';
        forEach($array as $k=>$v){
            $xml.='<'.$k.'><![CDATA['.$v.']]></'.$k.'>';
        }
        $xml.='</xml>';
        return $xml;
    }
    
    public static function dataRecodes($file,$title,$data){
        $handler = fopen($file,'a+');
        $content = "================".$title."===================\n";
        if(is_string($data) === true){
            $content .= $data."\n";
        }
        if(is_array($data) === true){
            forEach($data as $k=>$v){
                $content .= "key: ".$k." value: ".$v."\n";
            }
        }
        $flag = fwrite($handler,$content);
        fclose($handler);
        return $flag;
    }

    public static function parseXML($xmlSrc){
        if(empty($xmlSrc)){
            return false;
        }
        $array = array();
        $xml = simplexml_load_string($xmlSrc);
        $encode = Utils::getXmlEncode($xmlSrc);

        if($xml && $xml->children()) {
			foreach ($xml->children() as $node){
				//有子节点
				if($node->children()) {
					$k = $node->getName();
					$nodeXml = $node->asXML();
					$v = substr($nodeXml, strlen($k)+2, strlen($nodeXml)-2*strlen($k)-5);
					
				} else {
					$k = $node->getName();
					$v = (string)$node;
				}
				
				if($encode!="" && $encode != "UTF-8") {
					$k = iconv("UTF-8", $encode, $k);
					$v = iconv("UTF-8", $encode, $v);
				}
				$array[$k] = $v;
			}
		}
        return $array;
    }

    //获取xml编码
	function getXmlEncode($xml) {
		$ret = preg_match ("/<?xml[^>]* encoding=\"(.*)\"[^>]* ?>/i", $xml, $arr);
		if($ret) {
			return strtoupper ( $arr[1] );
		} else {
			return "";
		}
	}
}
?>