#!/bin/bash
echo Ten May: `hostname`
echo Thong tin ban phan phoi: `cat /etc/issue.net`
echo -e Thong tin CPU: `lscpu | grep "name\|Architecture\|Mhz"`
echo Thong tin bo nho vat ly: `df -h /dev/sda1 --output=size`
echo O dia con trong: `df -h /dev/sda1 --output=avail`
echo Danh sach dia chi IP: `ifconfig -a | grep "inet " | awk '{print $1 $2}'`
echo Danh sach cac user duoc sap xep: `cut -d: -f1 /etc/passwd | sort`
echo Thong tin cac tien trinh dang chay voi quyen root: 
echo `ps -U root -u root u | sort`
echo Thong tin cac port dang mo: `sudo netstat -tupln | grep "LISTEN" | sort`
echo Danh sach cac thu muc tren he thong cho phep other co quyen ghi:
echo `sudo find -type d -perm /o=w`
echo Cac goi cai dat tren he thong: `sudo apt list --installed`
