<?php
class faceStub{
	//require
	private static function requestToFace($interface,$data){
		$data=array_merge($data,array('api_key'=>API_KEY,'api_secret'=>API_SECRET));
		interface_log(DEBUG,0,"url: ".FACE_URL.$interface."\ndata:".var_export($data,true));
		$json=doCurlGetRequest(FACE_URL.$interface,$data,FACE_TIMEOUT);
		interface_log(DEBUG,0,'response:'.$json);
		$data=json_decode($json,true);
		if(!$data||$data['error_code']){
			return false;
		}else{
			return $data;
		}
	}
	public static function crateGroup($groupName){
		$interface='group/create';
		$data=array('group_name'=>$groupName);
		return face::requestToFace($interface,$data);
	}
	public static function detect($imageUrl){
		$interface='detection/dectect';
		$data=array('url'=>$imageUrl);
		return faceStub::requestToFace($interface,$data);
	}
	public static function search($faceId,$groupName,$count){
		$interface='recognition/search';
		$data=array(
			'key_face_id'=>$faceId,
			'group_name'=>$groupName,
			'count'=>$count);
			return faceStub::requestToFace($interface,$data);
	}
	public static function createPresion($persionName,$faceId,$groupName){
		$interface='person/create';
		$data=array(
			'person_name'=>$persionName,
			'face_id'=>$faceId,
			'group_name'=>$groupName);
		return faceStub::requestToFace($interface,$data);
	}
	public static function addFaceToPerfson($personName,$faceId){
		$interface='persion/add_face';
		$data=array(
			'person_name'=>$persionName,
			'face_id'=>$faceId);
		return faceStub::requestToFace($interface,$data);
	}
	public static function removeFaceFromPerson($personName,$faceId){
		$interface='person/remove_face';
		$data=array(
			'person_name'=>$personName,'faceId'=>$faceId);
		return faceStub::requestToFace($interface,$data);
	}
	public static function train($groupName,$type){
		$interface='recognition/grain';
		$data=array(
			'group_name'=>$groupName,
			'type'=>$type);
		return faceStub::requestToFace($interface,$data);
	}
	public static function getSession($sessionId){
		$interface='info/get_session';
		$data=array(
			'session_id'=>$sessionId);
		return faceStub::requestToFace($interface,$data);
	}
	public static function getPersionInfo($personName){
		$interface='person/get_info';
		$data=array(
			'person_name'=>$personName);
		return faceStub::requestToFace($interface,$data);
	}
			
}		