<?php
class Soundex
{
    /**
     * Bantu soundex implementation for PHP
     * By Kenneth Kapundi
     */

	public static function encode($str)
	{	
		$word = $str;
		if(empty($word)){
			return null;
		}
		
		# Drop all punctuation marks and numbers and spaces
		$word = preg_replace("([^A-Z])", "", strtoupper($word));
		
		# Words starting with M or N or D followed by another consonant should drop the first letter
		$word = preg_replace("/^M([BDFGJKLMNPQRSTVXZ])/", '\1', $word);
		$word = preg_replace("/^N([BCDFGJKLMNPQRSTVXZ])/", '\1', $word);
		$word = preg_replace("/^D([BCDFGJKLMNPQRSTVXZ])/", '\1', $word);
		
		# silent R enhancement (Margret, Esnart)
		$word = preg_replace("/(ARG)/", "AG", $word);
		$word = preg_replace("/(ART)/", "AT", $word);
		
		# THY and CH as common phonemes enhancement
		$word = preg_replace("/(THY|CH|TCH)/", "9", $word);
		
		# Retain the first letter of the word
		$initial = substr($word, 0, 1);		
		$tail = substr($word, 1, strlen($word));	
		
		# Initial vowel enhancement
		$initial = preg_replace("/[AEI]/", "E", $initial);
		
		# Initial C/K enhancement
		$initial = preg_replace("/[CK]/", "K", $initial);
		$initial = preg_replace("/[JY]/", "Y", $initial);
		$initial = preg_replace("/[VF]/", "F", $initial);
		$initial = preg_replace("/[LR]/", "R", $initial);
		$initial = preg_replace("/[MN]/", "N", $initial);
		$initial = preg_replace("/[SZ]/", "Z", $initial);

		# W followed by a vowel should be treated as a consonant enhancement
		$tail = preg_replace("/W[AEIOUHY]/", "8", $tail);	
		$tail = preg_replace("/[AEIOUHWY]/", "0", $tail);	
		$tail = preg_replace("/[BFPV]/", "1", $tail);	
		$tail = preg_replace("/[CGKQX]/", "2", $tail);	
		$tail = preg_replace("/[DT]/", "3", $tail);	
		$tail = preg_replace("/[LR]/", "4", $tail);	
		$tail = preg_replace("/[MN]/", "5", $tail);	
		$tail = preg_replace("/[SZ]/", "6", $tail);
		$tail = preg_replace("/[J]/", "7", $tail);	
		
		# Remove all pairs of digits which occur beside each other from the string
		$tail = preg_replace("/1+/", "1", $tail);	
		$tail = preg_replace("/2+/", "2", $tail);	
		$tail = preg_replace("/3+/", "3", $tail);	
		$tail = preg_replace("/4+/", "4", $tail);	
		$tail = preg_replace("/5+/", "5", $tail);	
		$tail = preg_replace("/6+/", "6", $tail);	
		$tail = preg_replace("/7+/", "7", $tail);	
		$tail = preg_replace("/8+/", "8", $tail);	
		$tail = preg_replace("/9+/", "9", $tail);	
		
		# Remove all zeros from the string
		$tail = preg_replace("/0/", "", $tail);	

		# Return only the first four positions
		return $initial.substr($tail, 0, 3);
	}
    
}
