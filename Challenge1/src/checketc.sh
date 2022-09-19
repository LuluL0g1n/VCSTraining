echo "[Log checketc - `date +%T` `date +%D'/'%m'/'%Y`]" >> /var/log/checketc.log
function createFile(){
	if [ ! -e $1 ]; then
		touch $1
	fi
}
function checkTextFile(){
	check=$(file -i $1 | grep -w "text/plain")
	if [[ $check ]]; then
		echo $line >> /var/log/checketc.log
		head -n 10 "$1" >> /var/log/checketc.log
	else 
		echo $1 >> /var/log/checketc.log
	fi
}

function checkNewFile(){
	old=$1
	curr=$2
	while read -r line; do
		check=$(grep -w $line -m 1 $old)
		if [ ! $check ]; then
			checkTextFile $line >> /var/log/checketc.log
			echo -e "\n" >> /var/log/checketc.log
		fi
	done < $curr
} 

function checkDeleteFile(){
	old=$1
	curr=$2
	while read -r line; do
		check=$(grep -w $line -m 1 $curr)
		if [ ! $check ]; then
			echo $line >> /var/log/checketc.log
		fi
	done < $old

}

	
listOldFiles='/home/lulul0g1n/Documents/task1/listoldfiles.txt'
listCurrentFiles='/home/lulul0g1n/Documents/task1/listcurrentfiles.txt'
listCheck='/home/lulul0g1n/Documents/task1/listcheck.txt'
#create files
createFile $listOldFiles
createFile $listCurrentFiles
createFile $listCheck
#write files
sudo find /etc -type f > $listCurrentFiles 
sudo find /etc -type f -cmin -30 > $listCheck

echo -e "\n===== Danh sach file tao moi =====\n" >> /var/log/checketc.log
checkNewFile $listOldFiles $listCheck

echo -e "\n===== Danh sach file sua doi =====\n" >> /var/log/checketc.log		
checkModified=$(sudo find /etc -mmin -30)
echo $checkModified | sed 's/ /\n/g' >> /var/log/checketc.log

echo -e "\n===== Danh sach file bi xoa =====\n" >> /var/log/checketc.log
checkDeleteFile $listOldFiles $listCurrentFiles
cat $listCurrentFiles > $listOldFiles

mail -s "Log checketc" root@localhost < /var/log/checketc.log

