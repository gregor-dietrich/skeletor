import os
import shutil

errors = 0
files = {
    "db.php": "../app/src/System/",
    "salt.php": "../app/src/System/"
}
root = os.path.dirname(__file__)

for filename, subdir in files.items():
    subdirs = subdir.split("/")[1:]
    pathing = "../"
    for dir in subdirs:
        pathing += dir + "/"
        if not os.path.exists(os.path.join(root, pathing)):
            os.mkdir(os.path.join(root, pathing))

    loc = os.path.join(root,  subdir, filename)
    if not os.path.isfile(loc):
        print("Couldn't find " + filename + ". Creating...")
        if os.path.isfile(loc[:-3] + "default.php"):
            shutil.copyfile(loc[:-3] + "default.php", loc)
        else:
            print("Error: " + filename[:-3] + "default.php not found.")
            errors += 1
    else:
        print(filename + " already exists. Skipping...")

print("\n%d Errors encountered during setup." % errors)
input("Press any key to exit... ")