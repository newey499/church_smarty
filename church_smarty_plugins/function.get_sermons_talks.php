<?php

/* 
 * name: function.get_sermons_talks.php
 * 
 * Smarty plugin to fetch mp3 sermons and talks
 * 
 */

error_reporting(E_ALL);

function smarty_function_get_sermons_talks($params, $smarty)
{
	// Call example
	// {get_sermons_talks fetch="RECENT" days=7 out="oSermonsTalks"}
	// days is optional (defaults to 7) and only applies when fetch type is "RECENT"
	
	require_once('php/class.StMp3.php');
	
	$daysParmValid = false;
	
	if (empty($params['fetch'])) 
	{
			trigger_error("assign: missing 'fetch' parameter");
			return;
	}
	else
	{
		if ( ! (StMp3::FETCH_ALL == $params['fetch'] || StMp3::FETCH_RECENT == $params['fetch']))
		{
				trigger_error("assign: 'fetch' parameter contains [" . 
					            $params['fetch'] .
											"] nor '" . StMp3::FETCH_ALL . "' or '" . StMp3::FETCH_RECENT . "'");
				return;
		}			
		
		if ((StMp3::FETCH_RECENT == $params['fetch']) && (in_array('days', array_keys($params))))
		{
			if (! empty($params['days']))
			{
				if (! ($params['days'] == intval($params['days'])))
				{
					trigger_error("'days' parameter of [" . $params['days'] . "] is not a valid +ve integer");
					return;
				}
				elseif (intval($params['days']) <= 0) 
				{
					trigger_error("'days' parameter of [" . $params['days'] . "] is not a valid +ve integer");
					return;					
				}
			}
		}
	}

	if (!in_array('out', array_keys($params))) 
	{
			trigger_error("assign: missing 'out' parameter");
			return;
	}


	if (StMp3::FETCH_ALL == $params['fetch'])
	{
		$oSt  = new StMp3($params['fetch']);	
	}
  else 
	{
		if (empty($params['days']))
		{
			$oSt  = new StMp3($params['fetch']);				
		}
		else 
	  {
			$oSt  = new StMp3($params['fetch'], $params['days']);				
		}
	}

	//$smarty->assign($params['out'], $oMenu);  
	$smarty->assign($params['out'], $oSt);  	
	
	return;	
}



?>