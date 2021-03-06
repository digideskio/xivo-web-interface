<?php

#
# XiVO Web-Interface
# Copyright (C) 2006-2016  Avencall
#
# This program is free software: you can redistribute it and/or modify
# it under the terms of the GNU General Public License as published by
# the Free Software Foundation, either version 3 of the License, or
# (at your option) any later version.
#
# This program is distributed in the hope that it will be useful,
# but WITHOUT ANY WARRANTY; without even the implied warranty of
# MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
# GNU General Public License for more details.
#
# You should have received a copy of the GNU General Public License
# along with this program.  If not, see <http://www.gnu.org/licenses/>.
#

xivo_service_asterisk::required(array('abstract','abstract.inc'),true);

class xivo_service_asterisk_usersip extends xivo_service_asterisk_abstract
{
	var $_dso		= null;
	var $_name		= 'usersip';
	var $_filter	= false;
	var $_origin	= false;

	public function __construct(&$sre,&$dso)
	{
		if(is_object($sre) === false)
			trigger_error('Invalid service in '.__CLASS__,E_USER_ERROR);

		if(is_object($dso) === false)
			trigger_error('Invalid datastorage in '.__CLASS__,E_USER_ERROR);

		$this->_sre = &$sre;
		$this->_dso = &$dso;

		$this->_load_config();
	}

	function _prepare($data)
	{
		$data['id'] = (int) $data['id'];
		$data['initialized'] = dwho_has_len($data['fullcontact']);
		$data['commented'] = (bool) $data['commented'];
		$data['identity'] = strtoupper($data['protocol']).'/'.$data['name'];

		return($data);
	}

	function get_nb($arr=null,$disable=null,$initialized=null)
	{
		if($arr !== null && is_array($arr) === false)
			return(false);
		else if(is_array($arr) === true
		&& ($arr = $this->get_element_where($arr)) === false)
			return(false);

		return($this->_dso->get_nb($arr,$disable,$initialized));
	}

	function add($arr,$id=0)
	{
		if(is_array($arr) === false)
			return(false);

		if(isset($arr['name']) === true)
			$arr['name'] = strtolower($arr['name']);

		$arr['type'] = 'friend';
		$arr['username'] = null;
		#$arr['md5secret'] = md5($arr['secret']);
		$arr['fullname'] = null;
		$arr['cid_number'] = null;
		$arr['mohinterpret'] = null;
		$arr['defaultip'] = null;
		$arr['port'] = null;
		$arr['regexten'] = null;
		$arr['subscribecontext'] = null;
		$arr['fullcontact'] = null;
		$arr['vmexten'] = null;
		$arr['callingpres'] = null;
		$arr['ipaddr'] = '';
		$arr['regseconds'] = 0;
		$arr['regserver'] = null;
		$arr['lastms'] = '';
		$arr['protocol'] = XIVO_SRE_IPBX_AST_PROTO_SIP;
		$arr['category'] = 'user';

		return(parent::add($arr,$id));
	}

	function edit($id,$arr,$disable=null)
	{
		if(is_array($arr) === false)
			return(false);

		if(isset($arr['name']) === true)
			$arr['name'] = strtolower($arr['name']);

		if(isset($arr['secret']) === true
		&& empty($arr['secret']) === false)
		{
		      $arr['secret'] = $arr['secret'];
		     # $arr['md5secret'] = md5($arr['secret']);
		}
		else
		{
			unset($arr['secret'],
			      $arr['md5secret']);
		}
		$arr['md5secret'] = '';

		unset($arr['username'],
		      $arr['fullname'],
		      $arr['cid_number'],
		      $arr['mohinterpret'],
		      $arr['defaultip'],
		      $arr['port'],
		      $arr['regexten'],
		      $arr['subscribecontext'],
		      $arr['fullcontact'],
		      $arr['vmexten'],
		      $arr['callingpres'],
		      $arr['ipaddr'],
		      $arr['regseconds'],
		      $arr['regserver'],
		      $arr['lastms']);

		$arr['type'] = 'friend';
		$arr['subscribecontext'] = null;
		$arr['protocol'] = XIVO_SRE_IPBX_AST_PROTO_SIP;
		$arr['category'] = 'user';

		return(parent::edit($id,$arr,$disable));
	}
}

?>
