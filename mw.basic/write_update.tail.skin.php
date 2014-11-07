<?php
/**
 * Bechu-Basic Skin for Gnuboard4
 *
 * Copyright (c) 2008 Choi Jae-Young <www.miwit.com>
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 */

if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가 

if ($mw_basic[cf_contents_shop_write] && $w == "") {
    mw_buy_contents2($member[mb_id], $mw_basic[cf_contents_shop_write_cash], "$board[bo_subject] 게시물 작성", $bo_table, $wr_id);
}

//if (function_exists('mw_moa_insert') && !$wr_anonymous && $mw_basic[cf_attribute] != 'anonymous') {
if (function_exists('mw_moa_insert')) {
    mw_moa_insert($write[wr_id], $wr_id, $write[mb_id], $member[mb_id]);
}

if (function_exists('mw_lucky_writing') && $w == '') {
    mw_lucky_writing($bo_table, $wr_id);
}

sql_query(" delete from $mw[temp_table] where bo_table = '$bo_table' and mb_id = '$member[mb_id]' ", false);

if ($mw_basic[cf_content_align] && $wr_align) {
    sql_query(" update $write_table set wr_align = '$wr_align' where wr_id = '$wr_id' ");
}

if ($is_admin && $contents_shop_id && $mw_basic[cf_contents_shop]) {
    $tmp = sql_fetch("select * from $g4[member_table] where mb_id = '$contents_shop_id'");
    if ($tmp) {
        sql_query("update $write_table set mb_id = '$contents_shop_id' where wr_id = '$wr_id'");
    }
}

if ($is_admin && $wr_to_id && $mw_basic[cf_attribute] == "1:1") {
    $tmp = sql_fetch("select * from $g4[member_table] where mb_id = '$wr_to_id'");
    if ($tmp) {
        sql_query("update $write_table set wr_to_id = '$wr_to_id' where wr_id = '$wr_id'");
    }
}

if ($mw_basic[cf_image_outline]) {
    for ($i=0, $m=count($upload); $i<$m; ++$i) {
        $dest_file = "$g4[path]/data/file/$bo_table/" . $upload[$i][file];
        if (is_file($dest_file)) {
            mw_image_outline($dest_file);
        }
    }
}

include_once($board_skin_path.'/mw.proc/naver_syndi.php');

if ($mw_basic['cf_include_write_update'] && is_file($mw_basic['cf_include_write_update'])) {
    include($mw_basic['cf_include_write_update']);
}

