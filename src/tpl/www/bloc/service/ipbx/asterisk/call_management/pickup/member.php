<?php

#
# XiVO Web-Interface
# Copyright (C) 2006-2014  Avencall
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

	$form = &$this->get_module('form');
	$url = &$this->get_module('url');

	$category     = $this->get_var('category');
	$membertype   = $this->get_var('membertype');
	$info         = $this->get_var('info');
	$datasource   = $this->get_var($category,$membertype);

	$type         = $category.'-'.$membertype;

	$typeurl      = array(
		'groups' => 'service/ipbx/pbx_settings/groups',
		'queues' => 'callcenter/settings/queues',
		'users'  => 'service/ipbx/pbx_settings/users'
	);

	if(count($datasource) > 0 || (array_key_exists($category.'s',$info) && count($info[$category.'s'][$membertype]))) {

		echo $form->jq_select(array(
						'name'    => $type."[]",
						'labelid' => $type,
						'paragraph'   => false,
						'class'   => 'multiselect',
						'multiple' => true,
						'key'   => 'identity',
						'altkey'   => 'id',
						//'jqmode'    => 'list',
						'selected'  => $this->get_var('info',$category.'s', $membertype)),
				$datasource);

	} else {
		echo    "<div id=\"fd-create-$type\" class=\"txt-center\">",
			$url->href_htmln($this->bbf('create_'.$membertype),
				$typeurl[$membertype],
				'act=add'),
			'</div>';
	}
//	endif;
?>
