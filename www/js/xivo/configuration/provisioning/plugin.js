/*
 * XiVO Web-Interface
 * Copyright (C) 2006-2011  Proformatique <technique@proformatique.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */

var delay = (function(){
  var timer = 0;
  return function(callback, ms){
    clearTimeout (timer);
    timer = setTimeout(callback, ms);
  };
})();

$(function(){
	mt = ($('#tb-list-pkgs').height() / 2) - ($('#box_installer').find('div').height() / 2);
	$('#box_installer').css('height',$('#tb-list-pkgs').height()+'px');
	$('#box_installer').css('width',$('#tb-list-pkgs').width()+'px');	
	$('#box_installer').find('div').css('margin-top',mt+'px');
	$('#box_installer').hide();
});

function init_install(plugin,id)
{
	$('#box_installer').show();
	$.get('/xivo/configuration/ui.php/provisioning/plugin?act=install-pkgs&plugin='+plugin+'&id='+id, function(data) {
		if (data === null)
			return false;
		ajax_request_oip(data,plugin);
		this.int = setInterval(ajax_request_oip,1000,data,plugin);
	});
}

function ajax_request_oip(url,plugin)
{
	$.get('/xivo/configuration/ui.php/provisioning/plugin?act=request_oip&id='+plugin+'&path='+url, function(data) {
		if (data === null)
			return false;
		if (data.indexOf( "act=edit" ) > -1) {
			$('#box_installer').hide();
			top.location.href = data;
		}
		else {
			$('#box_installer').find('div').html(data);
		}
	});
}