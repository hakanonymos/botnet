<?php
include_once("./includes/header.php"); 
?>
<main>
 <div class="container">
   <h1 class="thin">Help</h1>
    <div id="dashboard">
           <div class="row">
          <div class="col s12 m6 l6">
          <div class="card">
             <ul class="collapsible" data-collapsible="accordion">
  <li>
    <div class="collapsible-header active ">
      <i class="mdi-av-web"></i>
    <h5><b>What language is DarkC0ders botnet programmed in?</b></h5>

      </div>
    <div class="collapsible-body active">	<p>DarkC0ders special edition botnet is programmed in <b>C#, using the .NET 2.0 Framework</b>.<br/><br/></p></div>
  </li>
   <li>
    <div class="collapsible-header  ">
      <i class="mdi-editor-format-quote"></i>
    <h5><b>What do I enter for a parameter?</b></h5>
      </div>
    <div class="collapsible-body"><p>Parameters are only required for a few of the commands listed on the page. For example, if you wanted to execute the Download & Execute command, your parameter would be the link to the file you want downloaded & executed. Another example, if you wanted to view a webpage, your parameter would be the link to the page you want to view. There are only 3 categories that require parameters, and that is <b>Downloads, Webpages, and Bot Management (Update)</b>.</p></div>
  </li>
 
</ul>
          </div>
       

        </div>
          <div class="col s12 m6 l6">
          <div class="card">
            <ul class="collapsible" data-collapsible="accordion">
  <li>
    <div class="collapsible-header active ">
      <i class="mdi-file-cloud-off"></i>
    <h5><b>What are dead bots?</b></h5>
      </div>
    <div class="collapsible-body"><p>Bots that are marked <b>dead</b> have not connected to the panel in a specified amount of days. For example, the default limit is 7 days. Bots that have not connected to the panel within 7 days from their last connection, are then marked dead.</p></div>
  </li>
  <li>
    <div class="collapsible-header ">
      <i class="mdi-file-cloud-done"></i>
  <h5><b>What is 'Mark'?</b></h5>
      <span class="badge">1</span></div>
    <div class="collapsible-body"><p>A <b>Mark</b> is a way to tell if the bot is known as 'Clean' or 'Dirty'. Dirty bots usually have other malware loaded onto the system besides DarkC0ders's bot. The user (you) marks the bot as dirty when running a command on the panel. You can also mark the bot as clean for future reference.</p></div>
  </li>
</ul>
          </div>
        </div>	

		
		</div>
		<div class="col s12 m6 l6">
          <div class="card">
            <ul class="collapsible" data-collapsible="accordion">
 
  <li>
    <div class="collapsible-header active ">
      <i class="mdi-content-content-cut"></i>
					<h5><b>How do I use filters?</b></h5>

      <span class="badge">1</span></div>
    <div class="collapsible-body"><p><b>Filters</b> are used to include specific bots in a command, or exclude bots from a command. To use filters, you must specify what kind of filter it is. The format is as follows: <b>filter:filter parameters;</b>. For example, if you only wanted bots from the United States to execute your command, your filter would look something like this: <b>country:united states;</b>. The semicolon represents the end of this filter. If you wanted more than one value per filter, you would separate them with a comma. For example: <b>country:united states,canada;</b>. You can also have more than one filter at the same time. An example: <b>country:canada;privileges:admin;</b>. If you are still having trouble, feel free to contact <a href="https://www.facebook.com/achu.aravind.72">me</a> on FB for help. <u><b>Filters are currently disabled while they're being re-worked.</b></div>
  </li>
</ul>
          </div>
        </div>
		 </div>
	 </div>
 </div>
		
</main>
<?php include_once("includes/footer.php"); 
 ?>