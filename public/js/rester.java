

/* 
 * Name: Rester Chifundo Goliati
 * Code Names: Night King of Coding, Grim Reaper of Coding
 * Affiliation: ***classified***
 * Favorite Weapons: Linux Bash Terminal, John The Reaper
 * Timestamp: 15/08/2020 10:40:33:12
 * Filename: ResterWorld.java
 */

package com.resterworld.biography;

import god.humans.Status;

public class ResterWorld{
    public static void main(String[] args){
        runService();
    }

    private void runService(){
        Status humanObject = new Status();
        while(humanObject.isHumanAlive("Rester Goliati")){
            eat();
            sleep();
            code();
        }
    }

    private void eat(){/* run eat service */}
    private void sleep(){/* run sleep service */} 
    private void code(){/* run code service */}
}