#include <stdio.h>
#include <stdlib.h>
#include <pwd.h>
#include <grp.h>

int main() {
    char usr[50];
    int i;
    printf("Enter username you want to check infomation: ");
    scanf("%s", usr);
    struct group *gr;
    struct passwd *usrinfo;
    usrinfo = getpwnam(usr);
    if(usrinfo==0) {
        printf("User %s don't exist \n", usr);
        exit(EXIT_SUCCESS);
    }
    printf("Name: %s", usrinfo->pw_name);
    printf("\nID: %d", usrinfo->pw_uid);
    printf("\nHome Directory: %s", usrinfo->pw_dir);

    int numgr = 0; 
    getgrouplist(usrinfo->pw_name, usrinfo->pw_gid, NULL, &numgr); // return -1 due to the user is a member of more than *numgr groups (current numgr = 0)
    gid_t listgr[numgr]; // declare an array of GroupID
    getgrouplist(usrinfo->pw_name, usrinfo->pw_gid, listgr, &numgr);
    
    printf("\nGroups: ");
    for (i = 0; i < numgr; i++) {
        gr = getgrgid(listgr[i]); // returns pointer to struct group (get the struct group ID's info)
        printf("%s ", gr->gr_name);
    }
    printf("\n");       
}

