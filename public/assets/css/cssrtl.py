#!/usr/bin/python
# $Header: /home/guyru/cvsroot/css-scripts/cssrtl.py,v 1.4 2006/11/06 14:23:13 guyru Exp $
"""ltr-rtl and vice versa css convertor
Author: Guy Rutenberg
License: GPLv2
Version: 1.4.0
This script takes a css file and converts it to rtl design. This script also supposed to convert an rtl design into a ltr design but this feature wasn't tested.

Notes:
* You should check and set the direction statement yourself as suited for your design, as the script doesn't look for it.
"""
###########################################################################
 #   Copyright (C) 2006 by Guy Rutenberg                                   #
 #   guyrutenberg@gmail.com                                                #
 #                                                                         #
 #   This program is free software; you can redistribute it and/or modify  #
 #   it under the terms of the GNU General Public License as published by  #
 #   the Free Software Foundation; either version 2 of the License, or     #
 #   (at your option) any later version.                                   #
 #                                                                         #
 #   This program is distributed in the hope that it will be useful,       #
 #   but WITHOUT ANY WARRANTY; without even the implied warranty of        #
 #   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the         #
 #   GNU General Public License for more details.                          #
 #                                                                         #
 #   You should have received a copy of the GNU General Public License     #
 #   along with this program; if not, write to the                         #
 #   Free Software Foundation, Inc.,                                       #
 #   59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.             #
############################################################################

###############
#   CHANGELOG
# 1.4
# *now adding signature to files (user has the option to disable)
# *add ability to add a direction:rtl statement
#
# 1.3:
# *improved user interface
# *now using optparse
# *ability to select output file;

import sys
import re
from optparse import OptionParser

_version = "1.4.0"

def process(line):
	"""This function process each line and converts the line's direction """
	#swap right and left.
	pattern = re.compile(r'([:\s-]|^)(right)([:;\s])', re.IGNORECASE)
	line = pattern.sub(r'\1le^^^ft\3',line)
	
	pattern = re.compile(r'([:\s\b-]|^)(left)([:;\s])', re.IGNORECASE)
	line = pattern.sub(r'\1right\3',line)
	
	pattern = re.compile(r'([:\s\b-]|^)(le\^\^\^ft)([:;\s])', re.IGNORECASE)
	line = pattern.sub(r'\1left\3',line)
	
	#handle margin's shorthand
	#because we need to reference later when we swap left and right we will have to 
	#enter 4 times the expersision for the units
	pattern = re.compile(r'(\s*margin\s*:)(\s*\d+(px|em|ex|%|in|cm|mm|pt|pc|\b))(\s*\d+(px|em|ex|%|in|cm|mm|pt|pc|\b))(\s*\d+(px|em|ex|%|in|cm|mm|pt|pc|\b))(\s*\d+(px|em|ex|%|in|cm|mm|pt|pc|\b))',re.IGNORECASE)
	line = pattern.sub(r'\1\2\8\6\4',line)
	
	#do the same for padding
	pattern = re.compile(r'(\s*padding\s*:)(\s*\d+(px|em|ex|%|in|cm|mm|pt|pc|\b))(\s*\d+(px|em|ex|%|in|cm|mm|pt|pc|\b))(\s*\d+(px|em|ex|%|in|cm|mm|pt|pc|\b))(\s*\d+(px|em|ex|%|in|cm|mm|pt|pc|\b))',re.IGNORECASE)
	line = pattern.sub(r'\1\2\8\6\4',line)
	
	
	return line

def main():
	
	usage = "usage: %prog [options] FILENAME" # the usage string for OptionParser
	version="%prog "+_version
	parser = OptionParser(usage=usage, version=version, description="A script that reduce css files and restores them to readable form")
	parser.add_option("-o", "--ouput",
		type="string", dest="output", metavar="FILE",
		help="tells the script to which file it should write the output. [default: the input filename]")
	parser.add_option("-s", "--no-signature",
		action="store_true", default=False, dest="no_signature",
		help="do not add the cssrtl.py signuture to the css file")
	parser.add_option("-d", "--add-direction",
		action="store_true", default=False, dest="direction",
		help="adds a direction statement that will overide the existing ones")
	(options, args) = parser.parse_args()
	
	if len(args)<1:
		parser.error("You must supply an input filename")
	if len(args)>1:
		print "Ignoring arguments: ", ", ".join(["%s" % (arg,) for arg in args[1:]])
	
	if options.output==None:
		options.output=args[0];
		
	try:
		file = open (args[0], 'r')
	except IOError:
		print "Couldn't open file ", args[0], " reading"
		
	newcontent=''
	
	if not options.no_signature:
		newcontent='/* Translated to RTL using cssrtl.py by Guy Rutenberg */\n'
		
		
	for line in file.readlines():
		newcontent += process(line)
	file.close;
	
	#before writing to the file add a direction statement if needed
	if options.direction:
		newcontent+='\nbody { direction:rtl; }\n'
	
	try:
		file = open (options.output, 'w')
	except IOError:
		print "Couldn't open file  ", options.output, " writing"
	file.write(newcontent)
	file.close()

if __name__=="__main__":
	main()
	
	


	