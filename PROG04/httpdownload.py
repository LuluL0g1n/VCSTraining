#!/usr/bin/env python3 
import socket,argparse,re
import urllib.parse

parser = argparse.ArgumentParser()
parser.add_argument("--url", dest='host')
parser.add_argument("--remote-file", dest='file')
args = parser.parse_args()

host = args.host
file = args.file
def receive_all_data(s):
    data=[]
    receive = s.recv(1024)
    while (len(data) > 0):
        data.append(receive)
        receive = s.recv(1024)
    all_data = b''.join(data)
    return all_data

s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
domain = urllib.parse.urlparse(f'{host}').netloc
s.connect((domain,80))
request =  (f'GET {file} HTTP/1.1\r\n'+f'Host: {domain}\r\n'+f'Accept: */*\r\n\r\n')
s.send(request.encode())
response = receive_all_data(s)

if b"HTTP/1.1 200 OK" in response:
    len_file = re.findall(b"Content-Length: ([0-9]+)\r\n", response)[0].decode()
    print("File size is:"+len_file+"bytes")

    image = response.split(b'\r\n\r\n')[1]
    file_name = file.split("/")[-1]
	
    f = open(f"{file_name}", "wb")
    f.write(image)
    f.close()
	
else:
    print("File doesn't exit!!")
    exit()
