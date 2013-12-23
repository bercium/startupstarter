#!/usr/bin/env perl

my $command = 'php yiic.php'; 
exec ($command) or print STDERR "couldn't exec $command: $!";
