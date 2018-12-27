<?php
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////
/*This program will divide n players inputted by user to teams and deal cards to each team.  
When it is impossible to deal the same number of cards to all teams, some teams will receive an extra card and will be dealt first.  
*/
/////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////

//get input from from and assign to variable
$input = intval($_POST["n"]);

$suits = array('C', 'D', 'H', 'S');  //clubs, diamonds, hearts, spades
$cards = array('A', 2, 3, 4, 5, 6, 7, 8, 9, 10, 'J', 'Q', 'K');

$numbers = range(0, 51);

$deck = shuffle($numbers);

if($input <= 0 )
{
	exit('Input value does not exist or value is invalid');
}
else
{
	echo "There are ". $input . " players in the game.";
	echo "<br>";
	
	//if n > 52
	if($input > 52)
	{
		//num persons in each team
		$num_per_group = intval($input / 52);
	}
	else
	{
		$num_per_group = $input;
	}
	
	//num teams
	$num_groups = $input / $num_per_group;
	
	//count individuals or teams as players for simplicity
	//initialize
	$num_players =0;

	//more players than cards
	if($input > 52)
	{
		if(($input % 52) == 0)
		{
			echo $input . " players are equally divided into " . $num_groups ." groups of " . $num_per_group;
			echo "<br>";
			//exact so each playing team has same num persons
			$num_players = $num_groups; 
			echo "There are " . $num_players . " teams of players";
		}
		else
		{
			$leftover = $input % 52;
			echo $leftover . " teams of " . $num_per_group . " will have an extra person for a total of " . ($num_per_group + 1) . " players.";
			//num_players unaffected by the extra players
			$num_players = intval($num_groups);
			echo "There are " . $num_players . " teams of players";
		}
	}
	else
	{
		//less than number of cards so num players is just input
		$num_players = $input;
		echo "There are " . $num_players . " players";
	}
}
echo "<br>";

//////////////////////////////////////////////////////////////////////////////////
//initialize num cards dealt to each group
//$num_cards = 0;
//all players receive num_cards_all
$num_cards_all = intval(52 / $num_players);

echo "num_cards_all: ";
echo $num_cards_all;
echo "<br>";

//extra cards
$leftover_cards = 52 % $num_players;
 
//$num_players - $leftover_cards receive num_cards_all.
$receive_same = $num_players - $leftover_cards;
//leftover_cards players receive an additional card. 
$receive_more = $leftover_cards; 

//initialize counters
$count_cur = 0;
$count = 0;

//deal cards, use 52 in deck with $count increasing by $num_cards
//deal the players who receive more first
if($receive_more != 0)
{
	while($count < $receive_more) 
	{
    	for($count_cur = 0; $count_cur < ($num_cards_all + 1); $count_cur++)
    	{
    		$cur_card = array_pop($numbers);
    		print  $suits[$cur_card % 4] . "-" . $cards[$cur_card / 4] .  ", ";
    	}
    	//total count
    	$count++;
    	echo "<br>";
    }
    echo "count after dealing to receive_more: ";
    echo $count;
    echo "<br>";
    //reset count
    $count =0;
    //deal the rest of the cards to the players receiving 1 less
    while($count < $receive_same)
    {
    	for($count_cur = 0; $count_cur < $num_cards_all; $count_cur++)
    	{
    		$cur_card = array_pop($numbers);
    		print  $suits[$cur_card % 4] . "-" . $cards[$cur_card / 4] .  ", ";
    	}
    	$count++;
    	echo "<br>";
	}
}  
else //all players receive same num of cards
{
	while($count < 52)
    {
    	for($count_cur = 0; $count_cur < $num_cards_all; $count_cur++)
    	{
    		$cur_card = array_pop($numbers);
    		print  $suits[$cur_card % 4] . "-" . $cards[$cur_card / 4] .  ", ";
    	}
    	$count = $count + $num_cards_all;
    	echo "<br>";
	}
}

?>