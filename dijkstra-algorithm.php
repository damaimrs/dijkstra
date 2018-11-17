<?php

function dijkstraAlgorithm ($nodes, $awal, $akhir) {

	$ver = array();
	$next = array();

	foreach ($nodes as $node) {
		array_push($ver, $node[0], $node[1]);
		$next[$node[0]][] = array("tujuan" => $node[1], "cost" => $node[2]);
		$next[$node[1]][] = array("tujuan" => $node[0], "cost" => $node[2]);
	}

	$ver = array_unique($ver);
	$tujuan = array();

	foreach ($ver as $v) {
		$tcost[$v] = INF;
		$tujuan[$v] = NULL;
	}

	$tcost[$awal] = 0;
	$V = $ver;

	while (count($V) > 0) {

		$min = INF;

		foreach ($V as $vke) {
			if ($tcost[$vke] < $min) {
				$min = $tcost[$vke];
				$u = $vke;
			}
		}
		
		$V = array_diff($V, array($u));

		if ($tcost[$u] == INF or $u == $akhir) {
			break;
		}

		if (isset($next[$u])) {
			foreach ($next[$u] as $key => $n) {
				$cost = $tcost[$u] + $n["cost"];
				if ($cost < $tcost[$n["tujuan"]]) {
					$tcost[$n["tujuan"]] = $cost;
					$tujuan[$n["tujuan"]] = $u;
				}
			}
		}
	}

	$path = array();
	$akh = $akhir;

	while(isset($tujuan[$akh])) {
		array_unshift($path, $akh);
		$akh = $tujuan[$akh];
	}
	array_unshift($path, $awal);

	$result['path'] = $path;
	$result['cost'] = (int)$min;

	return $result;
}

$nodes = array(
		array("s", "a", 2),
        array("s", "b", 5),
        array("s", "c", 4),
        array("a", "b", 2),
        array("a", "d", 7),
        array("b", "c", 1),
        array("b", "d", 4),
        array("b", "e", 3),
        array("c", "e", 4),
        array("d", "e", 1),
        array("d", "t", 5),
        array("e", "t", 7)
	);

$hasil = dijkstraAlgorithm($nodes, "s", "t");

echo "path yang harus dilewati : ".implode(", ", $hasil['path'])."\n";
echo '<br>';
echo "total cost : "; 
echo (int)$hasil['cost'];

?>