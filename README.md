# `cget_01` - network wide clipboard

This code does not quite work as it is. It's purpose is mainly to show you
what is needed to make something like this work. The security code on the
PHP backend (`bouncer.php`) is not included for obvious reasons, nor are
the backends for any operation other than get. The `cget` family of
Python scripts (that use a `mysql` instance on the LAN as a backend)
illustrate the SQL required. It is very straightforward.

## Usage
To write to a clip:
```
echo hello | cput hello1
echo hello | cput boing:hello1 # non-default namespace
```
To read from a clip:
```
cget hello1
```
To list clips in a namespace
```
clist boing:.
```
Where the `.` is a regex (`.` matches any).

