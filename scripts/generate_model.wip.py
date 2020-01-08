
import json
import os
import sys


def parse_json(filename, charset):
    with open(filename, "r", encoding=charset) as file:
        data = file.read()

    module = json.loads(data)
    return module


def print_json(filename, charset):
    with open(filename, "r", encoding=charset) as file:
        data = file.read()

    module = json.loads(data)
    for k, v in module.items():
        if isinstance(v, list):
            print(k + " =>")
            spacing = " " * len(k)
            for column in v:
                print(spacing + " => " + column)
        else:
            print(k + " => " + v)


def main():
    filename = "./modules/examples/user.json"

    if os.path.isfile(filename):
        print("%s found! Parsing..." % filename)
        module = parse_json(filename, "utf-8")
        print(module["name"])
        print(module["plural"])
        print(module["namespace"])
        print(module["properties"])
        print(module["has_many"])
        print(module["has_one"])
    else:
        print("Error: Couldn't read %s." % filename)

    print("All operations completed. Exiting...")
    sys.exit()


main()
