Example project for "I ♥ PHP"
===

This repository contains the blog application code featured in the "I ♥ PHP" tutorial.
The tutorial has been designed for beginner and improving-beginner programmers wishing to learn
some good practices in PHP web development. The code example uses PDO/SQLite, and demonstrates
parameterisation, HTML escaping, logic/content separation, authentication, form handling, sessions
and proper password hashing. The repo is public so that experienced developers may propose
improvements if they wish.

Code changes in the tutorial are shown as diffs in the text, and each modified file can be
downloaded in its entirety at that point of development. To facilitate this, files and diffs are
extracted from this repo by a script, rather than being copied in manually. This means that
code improvements are much easier to transpose to the tutorial, than the traditional method of
making adjustments by hand.

Here is [a blog post about the tutorial](http://blog.jondh.me.uk/2014/08/online-php-beginners-tutorial/),
which is presently in alpha status.

See also the [text repo here](https://github.com/halfer/php-tutorial-text).

Development process
---

Since a fix may be necessary at an early stage of the project commit history, the approach I take
is to use Git's interactive rebase, and edit the file(s) in question. Once this is done, I continue
the rebase and fix up any resulting conflicts. Also, sometimes a new commit will be added, and
that too will be rebased into the correct order. As one would expect, either of these results in a
brand new commit history from the rebase point.

This has a number of ramifications. Firstly, the tutorial text cannot refer to commits by hash,
since they aren't reliable -- instead, commits are referred to by their comment text. Secondly,
modified branches need to be pushed with force in order to update their remote repositories. This
means that two people cannot work on the same branch, but in practice that's fine - changes of this
magnitude cannot really be merged anyway.

To make the process easier, sets of changes are added to a new branch in this repo, and the
tutorial is then set to read from that branch instead. In the future this will permit several
versions of the tutorial to co-exist, with each branch of the text repo referring to the
appropriate branch in this repo. This will be helpful for users who are midway through the course -
they can stay on the old version without incompatible changes being introduced that would force
them to start afresh.

How to help
---

It is a good idea to raise an issue ticket about your proposed changes first. I (and the readership)
will be most grateful for any improvements offered, but as maintainer I may have to turn down some
changes. We first need to ensure:

* the changes are actually an improvement
* no security issues are being introduced
* it is not overly complicated for a beginner audience
* it does not reiterate concepts that have already been illustrated

If we agree that the change is a good one, then read on.

Check out the code, and switch to the latest branch. For convenience, they start with "master" (the
oldest) and then go to "rebase1", and increase numerically from there. Create a new branch using
a name of your own choosing. Make your changes and rebase them into the order you believe is
suitable. Then push the new branch. If you have pushed before you will have to push with force;
that's okay though, as no-one else should be working on it!

You can then create a pull request (or an issue ticket) and we'll look at a diff against the current
branch to ensure the changes are good. If they are, I'll copy the branch into a new branch in the
main repo. Note this usually won't be merged into an existing branch (unless the change is very
trivial) so as to preserve earlier snapshots. I'll then push the changes to the tutorial server,
and regenerate against the new branch.
