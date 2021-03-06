<?php

#
# XiVO Web-Interface
# Copyright (C) 2006-2016 Avencall
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

$url = &$this->get_module('url');
$menu = &$this->get_module('menu');

$this->file_include('bloc/menu/top/user/loginbox');

?>
<div id="toolbox">
<div id="logo"><?=$url->img_html('img/menu/top/logo.gif',XIVO_SOFT_LABEL);?></div>
<div class="nav">
	 <ul>
<?php
	if(xivo_user::chk_acl_section('service') === true
	|| xivo_user::chk_acl_section('statistics') === true):
?>
		<li onmouseout="this.className = 'moo';"
		    onmouseover="this.className = 'mov';">
			<span class="span-left">&nbsp;</span>
			<span class="span-center"><?=$this->bbf('mn_top_services');?></span>
			<span class="span-right">&nbsp;</span>
			<div class="stab">
				<ul>
					<?php
					if(xivo_user::chk_acl_section('service/ipbx') === true):
					?>
					<li>
						<?=$url->href_html($this->bbf('mn_sub_top_services_ipbx'),
								   'service/ipbx');?>
					</li>
					<?php
					endif;
					?>
					<?php
					if(xivo_user::chk_acl_section('service/cti') === true):
						// get 1st authorized subsection
						foreach($_SESSION['_ACL']['user']['service']['cti'] as $sect => $subsecs)
						{
							foreach($subsecs as $subsec => $acl)
							{
								if($acl)
								{
					?>
					<li>
						<?=$url->href_html($this->bbf('mn_sub_top_services_cti'),
								   'cti/'.$subsec);?>
					</li>
					<?php
								break 2;
								}
							}
						}

					endif;
					?>
			   		<?php if(xivo_user::chk_acl_section('service/callcenter') === true): ?>
					<li>
						<?=$url->href_html($this->bbf('mn_sub_top_services_callcenter'),
								   'callcenter');?>
					</li>
					<?php endif; ?>
					<?php if(xivo_user::chk_acl_section('service/monitoring') === true): ?>
					<li>
						<?=$url->href_html($this->bbf('mn_sub_top_services_monitoring'),
								   'xivo');?>
					</li>
					<?php endif; ?>
					<?php if(xivo_user::chk_acl_section('service/graphs/munin') === true): ?>
					<li>
						<?=$url->href_html($this->bbf('mn_sub_top_services_stats'),
								   'graphs');?>
					</li>
					<?php endif; ?>
					<?php if(xivo_user::chk_acl_section('statistics/call_center') === true
					      || xivo_user::chk_acl_section('statistics/switchboard') === true): ?>
					<li>
						<?=$url->href_html($this->bbf('mn_sub_top_services_statistiques'),
								   'statistics');?>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</li>
<?php
	endif;

	if(xivo_user::chk_acl_section('xivo/configuration') === true):
?>
		<li onmouseout="this.className = 'moo';"
			onmouseover="this.className = 'mov';">
			<?=$url->href_html('<span class="span-left">&nbsp;</span>
						<span class="span-center">'.$this->bbf('mn_top_configuration').'</span>
						<span class="span-right">&nbsp;</span>',
						'xivo/configuration',
						null,
						null,
						$this->bbf('mn_top_configuration'));?>
		</li>
<?php
	endif;
?>
		<li onmouseout="this.className = 'moo';"
		    onmouseover="this.className = 'mov';">
			<?=$url->href_html('<span class="span-left">&nbsp;</span>
					    <span class="span-center">'.$this->bbf('mn_top_help').'</span>
					    <span class="span-right">&nbsp;</span>',
					   'xivo/help',
					   null,
					   null,
					   $this->bbf('mn_top_help'));?>
		</li>
		<li onmouseout="this.className = 'moo';"
		    onmouseover="this.className = 'mov';">
			<?=$url->href_html('<span class="span-left">&nbsp;</span>
					    <span class="span-center">'.$this->bbf('mn_top_contact').'</span>
					    <span class="span-right">&nbsp;</span>',
					   'xivo/contact',
					   null,
					   null,
					   $this->bbf('mn_top_contact'));?>
		</li>
	</ul>
</div>
<div id="tooltips">&nbsp;</div>
<div id="toolbar">
<?php
	$menu->mk_toolbar();
?>
</div>
</div>

<?php if (dwho_report::has('error') === true) : echo dwho_report::get_message('error'); endif; ?>
<?php if (dwho_report::has('warning') === true) : echo dwho_report::get_message('warning'); endif; ?>
<?php if (dwho_report::has('info') === true) : echo dwho_report::get_message('info'); endif; ?>
<?php if (dwho_report::has('notice') === true) : echo dwho_report::get_message('notice'); endif; ?>
<?php if (dwho_report::has('debug') === true) : echo dwho_report::get_message('debug'); endif; ?>
