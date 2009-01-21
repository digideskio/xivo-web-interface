<?php

#
# XiVO Web-Interface
# Copyright (C) 2006-2009  Proformatique <technique@proformatique.com>
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

$list = $this->get_varra('fktype_list','extension');

if(empty($list) === false):
	$fkdata = $this->get_var('fkdata');

	$select = array();
	$select['field'] = false;
	$select['name'] = 'phonefunckey[typeval][]';
	$select['label'] = false;
	$select['key'] = true;
	$select['bbf'] = array('concatkey','fm_phonefunckey_extension-typeval-opt-');
	$select['id'] = 'it-phonefunckey-extension-typeval';

	if($fkdata['ex'] === false):
		$select['id'] .= '-'.xivo_uint($fkdata['incr']);

		if($fkdata['type'] === 'extension'):
			$select['invalid'] = true;
			$select['value'] = $fkdata['extension'];
		endif;

		$selectoptattr = '';
	else:
		$select['disabled'] = true;

		$selectoptattr = ' onfocus="xivo_fm_set_onfocus(this);"'.
				 ' onblur="xivo_fm_set_onblur(this);"'.
				 ' style="display: none;"';
	endif;

	echo	$form->select($select,$list,$selectoptattr);
endif;

?>
