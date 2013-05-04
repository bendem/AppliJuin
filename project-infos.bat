@echo off
title Analyse du dossier
echo Analyse en cours...
"D:\Downloads\cloc-1.58.exe" --windows --exclude-ext="bat" --report-file="project-infos.txt" .
echo Fin de l'analyse
start notepad project-infos.txt
