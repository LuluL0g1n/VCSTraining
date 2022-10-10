#!/usr/bin/env python3

import socket,argparse, re
import urllib.parse

parser = argparse.ArgumentParser()
parser.add_argument("--url",dest="host")
parser.add_argument("--user",dest="usr")
parser.add_argument("--password",dest="pwd")
args = parser.parse_args()

host = args.host
user = args.usr
password = args.pwd

def receive_all_data(s):
    arr = ''
    data = s.recv(1024)
    while len(data) > 0:
        arr +=data.decode()
        data = s.recv(1024)
    return arr

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
domain = urllib.parse.urlparse(f'{host}').netloc
s.connect((domain,80))

info = f'log={user}&pwd={password}&wp-submit=Log+In'
request = ( f'POST /wp-login.php HTTP/1.1\r\n'+f'Host: {domain}\r\n'+f'Accept: */*\r\n'+f'Content-Length: {len(info)}\r\n'+f'Content-Type: application/x-www-form-urlencoded\r\n'+'\r\n'+f'{info}\r\n')
s.send(request.encode())

response = receive_all_data(s)
cookie_res = re.findall(r"Set-Cookie: (wordpress_logged_in_.*?)\r\n", response)
if cookie_res:
    print(f"User {user} Login Successfully!!!")
else:
    print(f"User {user} Login Failure!!!")
