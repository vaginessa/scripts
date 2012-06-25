import os, time
import locale
locale.setlocale(locale.LC_ALL, '')

root_path = "/home/user/public_html/dokuwiki/data/"

folder = root_path + "pages"
print(folder)
lines_count = 0
files_count = 0
folder_size = 0
 
for (path, dirs, files) in os.walk(folder):
	for file in files:
		filename = os.path.join(path, file)
		folder_size += os.path.getsize(filename)
		#print(filename)
		lines_count += len(open(filename).readlines())
		files_count += 1
 

print(time.strftime("%A %d %B %Y %H:%M", time.localtime()))
print("files: %d" % files_count)
print("lignes: %d" % lines_count)
print("pages size: %0.0f KB" % (folder_size/(1024.0)))

print("---")

files_count = 0
folder_size = 0

folder = root_path + "media"
folder_size = 0
for (path, dirs, files) in os.walk(folder):
	for file in files:
		filename = os.path.join(path, file)
		folder_size += os.path.getsize(filename)
		files_count += 1
print("media: %d" % files_count)
print("media size: %0.0f KB" % (folder_size/(1024.0)))


