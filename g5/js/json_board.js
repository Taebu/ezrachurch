/**
 * @author TaebuAir
*get_posts(10,ms_idx,pe_idx,applist,0);
* @param
*	size         : list size
*	ms_idx   : mobile site id
*	pe_idx   : page list id
*	call_id	  :  call UL #id list 
*	isNoti    : is notice
*  @write by mtb
*  
*  wday : 2013-09-27 Friday 20:00
*  place : anp company
* Test getJSON URL
* http://anptown2.cafe24.com/mobile/json.getBoardList.php?pe_idx=22&ms_idx=7&start=0&size=100
**/


function get_posts(size,ms_idx,pe_idx,callid,isNoti,searchkeyword){
	document.charset = 'utf-8';
//	var start = <?php echo $_SESSION['posts_start']; ?>;
$.getJSON("http://anptown2.cafe24.com/mobile/json.getBoardList.php", {status: "D",
	start:start,
	ms_idx:ms_idx,
	pe_idx:pe_idx,
	size:size,
	searchkeyword:searchkeyword,
	sb_notice:isNoti})
.done(function(data){
	var output='';
	if(data.count&&isData){
	$.each(data.posts,function(key,val) {
	output+=(isNoti=="1")?'<li class="noti">':'<li>';
	output+='<a href="#" onclick="showPost('+ val.uid +')">';
	output+= (val.sb_photo)?'<DIV class=thmb><img src="http://anptown2.cafe24.com/photo/thumb/'+val.sb_photo+'" onerror="this.src=\'http://anptown2.cafe24.com/photo/'+val.sb_photo+'\'" width=75 height=75 alt="'+val.title+'"/><SPAN class=mask></SPAN></DIV>':'<DIV class=no_thmb></DIV>';
	output+='<P><STRONG>'+val.sb_subject+'</STRONG>&nbsp;&nbsp;';
	output+=(data.sb_notice == "1")?'<span class="ic_noti">Notice</span>&nbsp;':'';
	output+=(val.day_diff <= 1)?'<span class="ic_new">New</span>':'';
	output+='<BR>';
	output+='<SPAN class=info><SPAN class=ty>'+val.sb_writer+'</SPAN><br>';
	output+= val.regdate.substring(0,10)+'<br>';
	output+='조회 : '+val.sb_hit+'</SPAN></p>';
	/*output+='<p>'+val.ms_lng+val.ms_lat+'</p>';*/
	output+='</a>';
	/*output+=(type)?type:'null';*/
	output+='<a class="cmt_num" href="#"><span class=hc>reply</span>'+val.sb_reply+'</a>';
	output+='</li>';
console.log(val.query);
console.log(val.where);
	}); //go through each postA
	start+=data.count;
console.log(searchkeyword);

//	$("html, body").animate({ scrollTop: $(document).height()}, "slow");
		}else{
			if(!isData)return;
		output+='';
///		isData=false;
	}
	//$('#applist').html(output);

	$('#'+callid).append(output);
})
.error(function() {
		var output='';
	$('#'+callid).append(output); 
});
}