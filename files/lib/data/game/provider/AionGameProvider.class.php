<?php
//wcf imports
require_once(WCF_DIR.'lib/data/game/provider/GameProvider.class.php');

/**
 * Represents the WoW GameProvider
 *
 * @author		Jeffrey 'Kiv' Reichardt
 * @copyright	2011 guilded.eu
 * @package     	com.guilded.data.game.wow
 * @subpackage	data.game.provider
 * @license     	CreativeCommons by-nc-sa <http://creativecommons.org/licenses/by-nc-sa/3.0/deed.de>
 */

class AionGameProvider extends GameProvider{
	public $url = 'http://%s.battle.net/';
	public $region = 'eu';
	
	/**
	 * @see GameProvider::readData()
	 */
	public function readData($url){
		parent::readData($url);
		
		if(!$this->receivedData) return;
		$this->receivedData = json_decode($this->receivedData);
	}
	
	/**
	 * @see GameProvider::getRealm()
	 */
	public function getRealm($name){
		$this->readData($this->getUrl().'api/wow/realm/status?realms='.urlencode($name));

		if(is_object($this->receivedData)){
			$this->outputData['name'] = $this->receivedData->realms[0]->name;
			$this->outputData['type'] = $this->receivedData->realms[0]->type;
			$this->outputData['population'] = $this->receivedData->realms[0]->population;
			$this->outputData['status'] = $this->receivedData->realms[0]->status;
			$this->outputData['queue'] = $this->receivedData->realms[0]->queue;
		}
		
		return $this->outputData;
	}
}

?>
