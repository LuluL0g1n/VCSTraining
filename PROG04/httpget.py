import socket
request = b"GET / HTTP/1.1\nHost: blogtest.vnprogramming.com\n\n"
s = socket.socket(socket.AF_INET, socket.SOCK_STREAM)
s.connect(("blogtest.vnprogramming.com", 80))
s.send(request)
data = ''
while not data.endswith('<title>'):
    data += s.recv(1).decode()
print("Title of Wordpress is: ")
title = ''
while not title.endswith('</title>'):
    title+=s.recv(1).decode()
print(title[:-8])
