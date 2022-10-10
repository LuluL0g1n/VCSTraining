import socket,argparse
import urllib.parse

parser = argparse.ArgumentParser()
parser.add_argument("--url",dest="host")
args = parser.parse_args()
host = args.host

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
domain = urllib.parse.urlparse(f'{host}').netloc
s.connect((domain, 80))

request = (f"GET / HTTP/1.1\r\n"+f"Host: {domain}\r\n"+f"Accept: */*\r\n"+'\r\n')
s.send(request.encode())
data = ''
while not data.endswith('<title>'):
    data += s.recv(1).decode()
print("Title of Wordpress is: ")
title = ''
while not title.endswith('</title>'):
    title+=s.recv(1).decode()
print(title[:-8])
