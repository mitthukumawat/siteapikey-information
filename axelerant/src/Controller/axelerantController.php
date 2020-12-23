<?php 
namespace Drupal\axelerant\Controller;
use Drupal\Core\Controller\ControllerBase;

class axelerantController extends ControllerBase {
	/**
     *
     * @param	siteapikey(int), node_id(int)
     * 
     * @return array
     */
    public function contentaccess($siteapikey, $nid) {
		$page_node = node_load($nid);	//Node object of $nid
        $apikey_info = \Drupal::config('system.site')->get('siteapikey');
        if ($siteapikey === $apikey_info) {
            if (!is_object($page_node)) {
                echo t('Content not exist, please varify the node id and try again');
                exit;
            }
            if ($page_node->getType() === 'page') {	//When the node parameter having content type is page
                $serializer = \Drupal::service('serializer');
                $jason_array = $serializer->serialize($page_node, 'json', ['plugin_id' => 'entity']);
                echo $jason_array;
                exit;
            }
            echo t('Content Type should be Page');
            exit;
        }
        echo t('Access Denied!');	// If trying to use incorrect site api key in url params.
        exit;
    }
}