<?php
/*
Plugin Name: WordPress AI Excerpt Generator (Gemini)
Description: Automatically generate compelling WordPress blog excerpts using Google Gemini AI with batching, progress tracking, and daily API limits.
Version: 2.0
Author: Prayag Sathyanath
*/

define('WAEG_DAILY_LIMIT',300);


/* ----------------------------------------------------
ADD ADMIN MENU
---------------------------------------------------- */

add_action('admin_menu', function(){

add_menu_page(
'AI Excerpt Generator',
'Smart Excerpts',
'manage_options',
'waeg-smart-excerpts',
'waeg_excerpt_page'
);

});


/* ----------------------------------------------------
API KEY SETTINGS
---------------------------------------------------- */

add_action('admin_init', function(){

register_setting('waeg_settings','waeg_gemini_api_key');

add_settings_section(
'waeg_section',
'Gemini API Configuration',
null,
'waeg_settings'
);

add_settings_field(
'waeg_api_key',
'Gemini API Key',
function(){

$value = esc_attr(get_option('waeg_gemini_api_key'));

echo "<input type='text' style='width:400px;' name='waeg_gemini_api_key' value='$value' placeholder='Enter Gemini API Key'>";

},
'waeg_settings',
'waeg_section'
);

});


/* ----------------------------------------------------
USAGE TRACKING
---------------------------------------------------- */

function waeg_get_today_usage(){

$today=date('Y-m-d');

$stored_date=get_option('waeg_usage_date');
$count=get_option('waeg_api_calls',0);

if($stored_date!=$today){

update_option('waeg_usage_date',$today);
update_option('waeg_api_calls',0);

return 0;

}

return $count;

}

function waeg_increment_usage(){

$count=waeg_get_today_usage();
$count++;

update_option('waeg_api_calls',$count);

}


/* ----------------------------------------------------
ADMIN PAGE
---------------------------------------------------- */

function waeg_excerpt_page(){

$usage=waeg_get_today_usage();
$api_key=get_option('waeg_gemini_api_key');

echo "<div style='padding:12px;background:#f1f1f1;border:1px solid #ccc;margin-bottom:20px;'>";

echo "<strong>Gemini Daily Usage:</strong> ".$usage." / ".WAEG_DAILY_LIMIT;

if($usage>=WAEG_DAILY_LIMIT){
echo "<br><span style='color:red;'>Daily limit reached. Generation disabled until tomorrow.</span>";
}

echo "</div>";

echo "<h2>Gemini API Settings</h2>";

echo "<form method='post' action='options.php'>";
settings_fields('waeg_settings');
do_settings_sections('waeg_settings');
submit_button('Save API Key');
echo "</form>";

?>

<h1>WordPress AI Excerpt Generator</h1>

<h2 class="nav-tab-wrapper">
<a href="#" class="nav-tab nav-tab-active" id="tab_view">Posts & Excerpts</a>
<a href="#" class="nav-tab" id="tab_tool">Generator Tool</a>
</h2>

<div id="view_tab">

<?php

$posts=get_posts([
'post_type'=>'post',
'numberposts'=>-1
]);

echo "<table class='widefat striped'>";
echo "<thead><tr><th>Post</th><th>Excerpt</th></tr></thead>";

foreach($posts as $post){

echo "<tr>";
echo "<td>".esc_html($post->post_title)."</td>";
echo "<td>".($post->post_excerpt ? esc_html($post->post_excerpt) : "<em>No excerpt</em>")."</td>";
echo "</tr>";

}

echo "</table>";

?>

</div>


<div id="tool_tab" style="display:none;">

<h3>Excerpt Generator Tool</h3>

<button id="scan_posts" class="button button-primary">Scan Posts</button>

<div id="scan_result" style="margin-top:15px;font-weight:bold;"></div>

<button id="start_generation" class="button button-secondary" style="display:none;">Generate Excerpts</button>

<div id="status" style="margin-top:20px;font-weight:bold;"></div>

<div style="margin-top:10px;width:100%;background:#ddd;height:22px;border-radius:4px;">
<div id="progress_bar" style="width:0%;height:100%;background:#2ea2cc;border-radius:4px;"></div>
</div>

<div id="progress_text" style="margin-top:8px;"></div>

<h3 style="margin-top:25px;">Live Log</h3>

<div id="log_panel" style="
background:#111;
color:#0f0;
padding:12px;
height:200px;
overflow:auto;
font-family:monospace;
font-size:13px;
"></div>

</div>


<script>

let offset=0;
let total=0;
let generated=0;

function log(message){

let panel=document.getElementById("log_panel");
panel.innerHTML += message+"<br>";
panel.scrollTop = panel.scrollHeight;

}

document.getElementById("tab_view").onclick=function(){

this.classList.add("nav-tab-active");
document.getElementById("tab_tool").classList.remove("nav-tab-active");

document.getElementById("view_tab").style.display="block";
document.getElementById("tool_tab").style.display="none";

}

document.getElementById("tab_tool").onclick=function(){

this.classList.add("nav-tab-active");
document.getElementById("tab_view").classList.remove("nav-tab-active");

document.getElementById("view_tab").style.display="none";
document.getElementById("tool_tab").style.display="block";

}

document.getElementById("scan_posts").onclick=function(){

fetch(ajaxurl,{
method:"POST",
headers:{"Content-Type":"application/x-www-form-urlencoded"},
body:"action=waeg_scan_posts"
})
.then(res=>res.json())
.then(data=>{

total=data.total;
generated=0;

document.getElementById("scan_result").innerHTML=
"Posts missing excerpts: "+total;

log("Scan complete. "+total+" posts require excerpts.");

document.getElementById("start_generation").style.display="inline-block";

})

}

document.getElementById("start_generation").onclick=function(){

document.getElementById("status").innerHTML="Starting generation...";
log("Starting excerpt generation...");

processBatch();

}

function updateProgress(){

let percent=0;

if(total>0){
percent=Math.round((generated/total)*100);
}

document.getElementById("progress_bar").style.width=percent+"%";

document.getElementById("progress_text").innerHTML=
generated+" / "+total+" excerpts generated ("+percent+"%)";

}

function processBatch(){

fetch(ajaxurl,{
method:"POST",
headers:{"Content-Type":"application/x-www-form-urlencoded"},
body:"action=waeg_generate_batch&offset="+offset
})
.then(res=>res.json())
.then(data=>{

if(data.limit_reached){

document.getElementById("status").innerHTML="Daily API limit reached";
log("Stopped: Daily API limit reached.");

return;

}

generated+=data.processed;

document.getElementById("status").innerHTML="Generating excerpts...";

updateProgress();

if(data.generated_titles){

data.generated_titles.forEach(function(title){
log("Generated: "+title);
});

}

if(data.more){

offset=data.next_offset;
processBatch();

}else{

document.getElementById("status").innerHTML="Completed ✔";
log("Generation completed.");

}

})

}

</script>

<?php
}


/* ----------------------------------------------------
SCAN POSTS
---------------------------------------------------- */

add_action('wp_ajax_waeg_scan_posts','waeg_scan_posts');

function waeg_scan_posts(){

if(!current_user_can('manage_options')){ exit; }

$posts=get_posts([
'post_type'=>'post',
'numberposts'=>-1
]);

$count=0;

foreach($posts as $post){

if(empty($post->post_excerpt)){
$count++;
}

}

wp_send_json([
'total'=>$count
]);

}


/* ----------------------------------------------------
GENERATE EXCERPTS
---------------------------------------------------- */

add_action('wp_ajax_waeg_generate_batch','waeg_generate_batch');

function waeg_generate_batch(){

if(!current_user_can('manage_options')){ exit; }

$current_usage=waeg_get_today_usage();

if($current_usage>=WAEG_DAILY_LIMIT){

wp_send_json([
'limit_reached'=>true
]);

}

$api_key=get_option('waeg_gemini_api_key');

if(!$api_key){

wp_send_json([
'limit_reached'=>true
]);

}

$offset=intval($_POST['offset']);

$posts=get_posts([
'post_type'=>'post',
'numberposts'=>10,
'offset'=>$offset
]);

$processed=0;
$generated_titles=[];

foreach($posts as $post){

if(!empty($post->post_excerpt)){
continue;
}

$content=wp_strip_all_tags($post->post_content);
$content=substr($content,0,1500);
$title=$post->post_title;

$response=wp_remote_post(

"https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash-lite:generateContent?key=".$api_key,

[
'timeout'=>20,
'headers'=>[
'Content-Type'=>'application/json'
],

'body'=>json_encode([
'contents'=>[
[
'parts'=>[
[
'text'=>"Write a 22–28 word blog excerpt encouraging readers to click the article. Do not repeat the title.

Title:
".$title."

Blog content:
".$content
]
]
]
]
])

]

);

if(is_wp_error($response)){
continue;
}

$raw = wp_remote_retrieve_body($response);
$body = json_decode($raw, true);

$summary=$body['candidates'][0]['content']['parts'][0]['text'] ?? '';

if($summary){

wp_update_post([
'ID'=>$post->ID,
'post_excerpt'=>trim($summary)
]);

waeg_increment_usage();

$processed++;

$generated_titles[]=$title;

}

}

wp_send_json([
'processed'=>$processed,
'generated_titles'=>$generated_titles,
'next_offset'=>$offset+count($posts),
'more'=>count($posts)==10
]);

}