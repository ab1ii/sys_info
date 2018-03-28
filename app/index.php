<!DOCTYPE html>
<?php
/*This is a series of tests to check  
*/?>
<html>
  <head> 
    <title>Sys Info</title>
    <link type="text/css" href="assets/ACT.css" rel="stylesheet" />
    <script src="js-ext/jquerycode/jquery-1.11.3.min.js"></script>

    <script>
      if(!document.getElementsByClassName)  //IE does not have getElementsByClassName... 
      {
          document.getElementsByClassName = function(className) {
          return this.querySelectorAll("." + className);
      };
      
     }
    </script>
  
  </head>

  <body>
    <script>
  
      function switchMode()
      {
       
       var preInstalls =  document.getElementsByClassName('preIn');
        if(document.getElementById('preCheck').checked)
        {
          for(var i = 0; i < preInstalls.length; i++) {
            preInstalls[i].style.display="none";
           }

        }
        else
        {
          for(var i = 0; i < preInstalls.length; i++) {
            preInstalls[i].style.display="";
           }
          
        }
      }

      function toggleConfigView()
      {
        var btn = document.getElementById('togButton');
        var dv = document.getElementById('codeView');

        
        if(btn.innerHTML =='Show')
        {
          dv.style.display = '';
          btn.innerHTML = 'Hide';
        }
        else
        {
          dv.style.display = 'none';
          btn.innerHTML = 'Show';
        }

      }

      function sendFeedback() {
        //Work in progress: collets the test results from the LI collection.  Adds the site name.
        //Will send to PHP service that emails us the resutls.  
        //May offer a text box to allow user to add commmetns

        var summary = new Array();
        var testResults = jQuery('li');
        testResults.each(function(idx, li) {
            summary.push(jQuery(li).text());    
           });
         
         ret = JSON.stringify(summary);
         //TODO:  send ret to service

         alert('The following data:\n\n' +ret + '\n\nHas been sent to us.  \nThank you.');               
        
            
      }


    </script>
  <section>
  <h2>System Info</h2>  
      <a href="#" onclick="location.reload();"   title="Get latest test results."  role="button" style="float:right;" >Refresh</a>
    <div id="errDiv">PHP Error. Please Check ACT_config.php for errors.&nbsp;<a href="https://community.i2b2.org/wiki/display/ACT/Issues" target="_blank" title="Opens the ACT Plugin Wiki page for ACT config  issues in a new tab">more info</a> </div>
  </section>
    
  <?php
  

require('ACT_inspector.php');

$summary = '<section><div><h3>Results</h3><ul>'; 
$styleClass='';

//Hidden Info to be sent for future send feedback option
//************************ */
global $ACT_configs;
$summary = $summary . '<li style="display:none;" >Site Name: ' . $ACT_configs['site_name'] . '</li>'; 

//"PRE" install checks
//************************ */
$results = new TestResults();
$results = testACT_getOSInfo();
$styleClass = setUIClass($results->fail,true);
$rm = $results->message;
$rm =  $rm . '&nbsp;' ;
$summary = $summary . '<li class="'.$styleClass.'">OS Info: ' .$rm . '</li>';

$results = new TestResults();
$results = testACT_getPHPVersion('php');
$styleClass = setUIClass($results->fail);
$rm = $results->message;
$rm =  $rm . '&nbsp;' ;
$summary = $summary . '<li class="'.$styleClass.'">PHP Version: ' .$rm . '</li>';

$results = new TestResults();
$results = testACT_getPHPVersion('curl');
$styleClass = setUIClass($results->fail);
$rm = $results->message;
$rm =  $rm . '&nbsp;' ;
$summary = $summary . '<li class="'.$styleClass.'">PHP cURL version: ' .$rm . '</li>';

$results = new TestResults();
$results = testACT_getPHPVersion('json');
$styleClass = setUIClass($results->fail);
$rm = $results->message;
$rm =  $rm . '&nbsp;' ;
$summary = $summary . '<li class="'.$styleClass.'">PHP Extension JSON version: ' .$rm . '</li>';



$summary = $summary . '</ui></div>';

$results = new TestResults();
$results = testACT_showACT_Config();
$rm = $results->message;
$rm =  $rm . '&nbsp;' ;


$summary = $summary . '</section>';


echo $summary;



function setUIClass($fail,$infoItem)
{
    if($fail)
      return 'fail';
    else
      if(! $infoItem)
        return 'pass';
        else
          return 'info';
}

?>

<script>
  //if the PHP require command for the config file, then this script will exe and hide the error div and show the pre install div
   document.getElementById('errDiv').style.display="none";
   document.getElementById('preCkDiv').style.display="";
   document.getElementById('acDiv').style.display="";
  </script>
  </body>

</html>



