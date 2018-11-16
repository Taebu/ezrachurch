<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가
?>
    </div>
</div>

<hr>

<nav id="gnb">
    <script>$('#gnb').addClass('gnb_js');</script>
    <h2>메인메뉴</h2>
    <ul>
        <?php
        $sql = " select * from {$g5['group_table']} where gr_show_menu = 1 and gr_device <> 'pc' order by gr_order ";
        $result = sql_query($sql);
        for ($gi=0; $row=sql_fetch_array($result); $gi++) { // gi 는 group index
        ?>
        <li><a href="<?php echo G5_BBS_URL ?>/group.php?gr_id=<?php echo $row['gr_id'] ?>"><?php echo $row['gr_subject'] ?></a></li>
        <?php } ?>
        <?php if ($gi == 0) { ?><li class="gnb_empty">생성된 메뉴가 없습니다.</a><?php } ?>
    </ul>
</nav>

<hr>

<?php echo poll('basic'); // 설문조사 ?>

<hr>

<div id="ft">
    <?php echo popular('basic'); // 인기검색어 ?>
    <?php echo visit('basic'); // 방문자수 ?>
    <div id="ft_catch"><a href="<?php echo G5_URL; ?>/"><img src="<?php echo G5_IMG_URL; ?>/ft_catch.jpg" alt="Sharing All Possibilities"></a></div>
    <div id="ft_copy">
        <p>
            Copyright &copy; <b>소유하신 도메인.</b> All rights reserved.<br>
            <a href="#">상단으로</a>
        </p>
    </div>
</div>

<?php
if(G5_USE_MOBILE && G5_IS_MOBILE) {
    $seq = 0;
    $href = $_SERVER['PHP_SELF'];
    if($_SERVER['QUERY_STRING']) {
        $sep = '?';
        foreach($_GET as $key=>$val) {
            if($key == 'device')
                continue;

            $href .= $sep.$key.'='.$val;
            $sep = '&amp;';
            $seq++;
        }
    }
    if($seq)
        $href .= '&amp;device=pc';
    else
        $href .= '?device=pc';
?>
<a href="<?php echo $href; ?>" id="device_change">PC 버전으로 보기</a>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}

include_once(G5_PATH."/tail.sub.php");
?>