<?php

header("Content-Type: application/xml; charset=ISO-8859-1");

echo '<?xml version="1.0" encoding="ISO-8859-1" ?>';
echo '<rss version="2.0">';
echo '<channel>';
echo '<title>Nexus 5 franco.Kernel release</title>';
echo '<link>http://forum.xda-developers.com/google-nexus-5/orig-development/kernel-franco-kernel-r32-t2508284</link>';
echo '<description>Nexus 5 franco.Kernel release</description>';
$date =  new DateTime();
echo '<pubDate>'. $date->format(DateTime::RSS) .'</pubDate>';

$changelog = file_get_contents('http://kernels.franco-lnx.net/Nexus5/5.0/appfiles/changelog.xml');

$versions = simplexml_load_string($changelog);

for($i=0;$i<10;$i++) {
    echo '<item>';
        echo '<title>Nexus5 Franco Kernel '.$versions->changelogversion[$i]['versionName']. ' - ' . $versions->changelogversion[$i]['changeDate'] .'</title>';
        echo '<link>http://kernels.franco-lnx.net/Nexus5/4.4/appfiles/changelog.xml</link>';
        echo '<description>';
          for($j=0; $j<count($versions->changelogversion[$i]->changelogtext); $j++) {
              echo $versions->changelogversion[$i]->changelogtext[$j] . "\n";
          }
        echo '</description>';
        echo '<guid>http://kernels.franco-lnx.net/Nexus5/5.0/appfiles/changelog.xml?'.$versions->changelogversion[$i]['versionName'].'</guid>';
    echo '</item>';

}

echo '</channel>';
echo '</rss>';
