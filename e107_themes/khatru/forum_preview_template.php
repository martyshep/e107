<?php
/*
 * e107 website system
 *
 * Copyright (C) 2001-2009 e107 Inc (e107.org)
 * Released under the terms and conditions of the
 * GNU General Public License (http://www.gnu.org/licenses/gpl.txt)
 *
 *
 *
 * $Source: /cvs_backup/e107_0.8/e107_themes/khatru/forum_preview_template.php,v $
 * $Revision: 1.2 $
 * $Date: 2009-11-12 15:01:33 $
 * $Author: marj_nl_fr $
 */

if (!defined('e107_INIT')) { exit; }

$FORUM_PREVIEW = 
($action != "nt" ? "" : " ( ".LAN_62.$tsubject." )")."
<table style='width:100%'>
<td style='width:20%' style='vertical-align:top'><b>".$poster."</b></td>
<td style='width:80%'>
<div class='smallblacktext' style='text-align:right'>".IMAGE_post2." ".LAN_322.$postdate."</div><br />".$tpost."</td>
</tr>
</table>";
	
?>