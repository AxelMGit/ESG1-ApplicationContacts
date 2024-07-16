<?php
function getContacts() {
    include 'contacts.php';
    return $contacts;
}

function saveContacts($contacts) {
    $content = "<?php\n\$contacts = " . var_export($contacts, true) . ";\n?>";
    file_put_contents('contacts.php', $content);
}
?>
