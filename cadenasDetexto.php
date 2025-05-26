<?php 
print "Hola desde 'PHP <br>" ; 
print 'Hola desde "PHP" <br>';
$nombre = "Leo";
print <<<EOD
Mi nombre es $nombre <br>
Mas Informacion <br>
EOD;

print <<<'EOD'
Mi nombre es $nombre <br>
Mas Informacion <br>
EOD;
?>