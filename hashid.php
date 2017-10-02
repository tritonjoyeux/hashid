<?php

function hashId($hash) {
	system("clear");
	$hash = trim(preg_replace('/\s\s+/', ' ', $hash));
	$hashList = ["fletcher-4", "Pearson hashing", "CRC-16", "Adler-32", "CRC-64", "md5", "sha1", "Tiger", "SHA-224", "bcrypt", "GOST", "RIPEMD-320", "SHA-384", "whirlpool", "RadioGatún"];

	if($hash == "--exit" || $hash == "--e" || $hash == "exit"){
		echo "\033[31m _                
| |               
| |__  _   _  ___ 
| '_ \| | | |/ _ \
| |_) | |_| |  __/
|_.__/ \__, |\___|
        __/ |     
       |___/      \033[0m\n";
		sleep(1);
		system("clear");
		die();
	}

	if($hash == "--help" || $hash == "--h" || $hash == "help"){
		echo "--------------------HASHID----------------------
		\nUsage: \033[31m'php hashid.php argv'\033[0m ou argv est le hash
		\nLe programme retournera le type de cryptage du hash
		\nOptions: \033[31m--help\033[0m (affiche la doc), \033[31m--list\033[0m (Affiche les différentd hash possible)
		\n----------------------END-----------------------";
		return;
	}

	if($hash == "--list" || $hash == "--l" || $hash == "list") {
		echo "--------------------HASHID----------------------
		\nListe des hash disponible :\n\t\t - \033[31m";
		echo implode("\033[0m\n\t\t - \033[31m", $hashList);
		echo "\033[0m\n----------------------END-----------------------\n";
		return;
	}

	$size = strlen($hash) * 4;

	if($size == 4){
		$wikiInfos = getWikiInfos("fletcher_checksum");
		return hashInfos($size, $wikiInfos, "fletcher-4");	
	}

	if($size == 8){ 
		$wikiInfos = getWikiInfos("pearson_hashing");
		return hashInfos($size, $wikiInfos, "Pearson hashing");
	}

	if($size == 16){
		$wikiInfos = getWikiInfos("CRC-16");
		return hashInfos($size, $wikiInfos, "CRC-16");
    }

    if($size == 32){
    	$wikiInfos = getWikiInfos("alder-32");
        return hashInfos($size, $wikiInfos, "Alder-32");
    }

    if($size == 64){
    	$wikiInfos = getWikiInfos("CRC-64");
    	return hashInfos($size, $wikiInfos, "CRC-64");
    }

    if($size == 128){ 
    	$wikiInfos = getWikiInfos("md5");
        return hashInfos($size, $wikiInfos, "MD5");
    }

    if($size == 160){
    	$wikiInfos = getWikiInfos("sha1");
        return hashInfos($size, $wikiInfos, "SHA1");
    }

    if($size == 192){
    	$wikiInfos = getWikiInfos("tiger_(cryptography)");
    	return hashInfos($size, $wikiInfos, "Tiger");
    }

    if($size == 224){
    	$wikiInfos = getWikiInfos("sha-224");
    	return hashInfos($size, $wikiInfos, "SHA-224");
    }

    if($size == 240){
    	$wikiInfos = getWikiInfos("bcrypt");
      	return hashInfos($size, $wikiInfos, "bcrypt");
    }

    if($size == 256){
    	$wikiInfos = getWikiInfos("gost");
    	return hashInfos($size, $wikiInfos, "GOST");
    }

    if($size == 320){
    	$wikiInfos = getWikiInfos("ripemd-320");
    	return hashInfos($size, $wikiInfos, "RIPEMD-320");
    }

    if($size == 384){
    	$wikiInfos = getWikiInfos("sha-384");
    	return hashInfos($size, $wikiInfos, "SHA-384");
    }

    if($size == 512){
    	$wikiInfos = getWikiInfos("whirlpool_(cryptography)");
        return hashInfos($size, $wikiInfos, "Whirlpool");
    }

    if($size >= 1216){
    	$wikiInfos = getWikiInfos("radiogatún");
    	return hashInfos($size, $wikiInfos, "RadioGatún");
    }

    return "/!\\ \033[31mNo hash detected\033[0m /!\\";
}

function getWikiInfos($search) {
	$url = 'http://en.wikipedia.org/w/api.php?action=query&prop=extracts|info&exintro&titles='.$search.'&format=json&explaintext&redirects&inprop=url&indexpageids';
    $json = file_get_contents($url);
    $data = json_decode($json);

    $pageid = $data->query->pageids[0];
	return "\nInfos : \033[31m".$data->query->pages->$pageid->extract."\033[0m\n";
}

function hashInfos($size, $wikiInfos, $hash){
	return "Hash found : \033[31m".$hash."\033[0m\nSize of bytes : \033[31m".$size."\033[0m".$wikiInfos;
}

system("clear");
echo "\033[31mWelcome to HashId\033[0m\nEnter your command or your hash (--help to usage, --exit, --e or exit to leave) :\n";	
while(1) {
    $handle = fopen("php://stdin", "r");
    $line = fgets($handle);
    echo hashId($line)."\n";
    fclose($handle);
    echo "Enter your command or your hash (--help to usage, --exit, --e or exit to leave) :\n";	
}