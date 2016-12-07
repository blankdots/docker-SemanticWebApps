<?php

$output = array();
$return_var = -1;

if (isset($_FILES['ontology'])) {
    $error = $_FILES['ontology']['error'];
    if ($error !== UPLOAD_ERR_OK) {
        setResponse(400, 'Upload failed.');
        return;
    }
    $startParameter = '-file ' . $_FILES['ontology']['tmp_name'];
} elseif (isset($_GET['iri'])) {
    $ontologyIRI = escapeshellarg($_GET['iri']);

    $prefix = 'http';
    if (strpos($ontologyIRI, $prefix) === false) {
        setResponse(400, 'Invalid IRI.');
        return;
    }

    $startParameter = '-iri ' . $ontologyIRI;
} else {
    setResponse(400, 'No request specified');
    return;
}

$command = 'java -jar owl2vowl.jar -echo ' . $startParameter;
$process = proc_open($command, array(1 => array("pipe", "w"), 2 => array("pipe", "w")), $pipes, dirname(__FILE__));

$output = stream_get_contents($pipes[1]);
fclose($pipes[1]);
$error_output = stream_get_contents($pipes[2]);
fclose($pipes[2]);

$return_var = proc_close($process);

if ($return_var === 0) {
    // success
    echo $output;
} else {
    setResponse(500, $error_output);
}

function setResponse($statusCode, $message)
{
    setResponseCode($statusCode);
    echo "Conversion failed. Error log: \n";
    // Should be formatted output
    echo htmlspecialchars($message);
}

function setResponseCode($responseCode)
{
    header('X-PHP-Response-Code: ' . $responseCode, true, $responseCode);
}