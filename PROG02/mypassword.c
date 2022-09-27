#include <unistd.h>
#include <pwd.h>
#include <stdio.h>
#include <string.h>
#include <stdlib.h>
#include <time.h>
#include <shadow.h>
#include <crypt.h>

char* gen_salt(char salt[]) {
    const char *const saltchr = "./0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
    int i, saltchr_len = strlen(saltchr);
    srand(time(NULL));
    for (i = 0; i < 16; i++) {
        unsigned int salt_rand = rand() % saltchr_len;
        salt[3+i] = saltchr[salt_rand];
    }
    return salt;
}

void remove_user(char user[]) {
    FILE *fptrr, *fptrw;
    fptrr = fopen("/etc/shadow", "r");
    if(fptrr == NULL) {
      printf("Error opening file /etc/shadow\n");   
      exit(1);             
    }
    fptrw = fopen("/tmp/shadow", "w");
    if(fptrw == NULL) {
      printf("Error writing file /tmp/shadow\n");   
      exit(1);             
    }
    char arr[256];
    char *p, *tmp;
    while (fgets(arr, 256, fptrr) != NULL) {
        strcpy(tmp, arr);
        p = strtok(arr, ":");
        if (strcmp(user, p) != 0) {
             fprintf(fptrw, "%s", tmp);
        }
    }
    fclose(fptrr);
    fclose(fptrw);
    remove("/etc/shadow");
    rename("/tmp/shadow", "/etc/shadow");
}

int check_password(char password[], char user[]) {
    struct spwd* shadow = getspnam(user);
    if (shadow != NULL) {
        return strcmp(shadow->sp_pwdp, crypt(password, shadow->sp_pwdp));
    }        
}
int check_username(char user[]) {
    struct passwd *usrinfo;
    usrinfo = getpwnam(user);
    if(usrinfo==0) {
        printf("User %s don't exist \n", user);
        return 0;
    }
    return 1;
}

int main() {
    char curr_passwd[256], new_passwd[256], user[50];
    char salt[20] = "$6$";
    struct spwd *shadow_entry;
    printf("Input username: ");
    scanf("%s", user);
    if (check_username(user)==0) {
    	exit(EXIT_SUCCESS);
    }
    printf("Input current password: ");
    scanf("%s", curr_passwd);
    char shadow_entry_name[128];
    if (!check_password(curr_passwd, user)) {
        while ((shadow_entry = getspent()) != NULL) {
            strcpy(shadow_entry_name, shadow_entry->sp_namp);
            if(!strcmp(shadow_entry_name, user)) {
                break;
            }
        };       
        printf("Input a new password: ");
        scanf("%s", new_passwd);
        strcpy(salt, gen_salt(salt));
        char* hash_char = crypt(new_passwd, salt);
        remove_user(user);
        shadow_entry->sp_pwdp = hash_char;       
        FILE* shadow_file = fopen("/etc/shadow", "a");
        if (!shadow_file) {
            printf("Failed to open file /etc/shadow! Permission denied\n");
            remove("/tmp/shadow");
            return 0;
        }
        if (putspent(shadow_entry, shadow_file) == -1) {
            printf("An error occurred\n");
            return 0;
        }      
        printf("Password updated successfully!!!\n");
        return 1;
    }   
    printf("Password authentication failure\n");
    return 1;
    
}

