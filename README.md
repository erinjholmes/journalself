# journalself

This is where we can privately push and pull our code for the Journalself.org site and Jself.org. This is our development environment.

Approximate work flow:

1. Make a clone of master branch at the root of the JournalSelf server (how to avoid subfolder?)

git clone <repository URL>
Clones the repository in the default branch at the latest timeline point to a folder with the same name as the repository.
Detailed instructions: https://help.github.com/en/github/creating-cloning-and-archiving-repositories/cloning-a-repository

2. Make a development branch at GitHub.

git branch <branch name>

Creates a new branch (timeline). The point of bifurcation is determined by your current location in the timeline. It is possible to group some class of development by using for example “feature/new_feature1” as name of branch. If somewhere later a branch named “feature/new_feature2” is created, these are well organised.

3. Clone the branch to the JournalSelf server (staging folder)

4. Protect the staging folder with the password

5. Work in staging folder:

5.1. git status

Checks the status of the local timeline such as if there are files that changed, something staged or if the server repository is ahead of the local timeline.

5.2. git add <files>
  
Prepares the files selected for committing (update in a new timeline point). This is called “putting the files on the stage” (as in theatre or stadium stage)
  
5.3. git commit -m "<Descriptive commit message of what changed and why. Use shell line wrap in order to put multiline messages. Think of it as a sort of log book. If it’s organised, you know why you did stuff>"

Adds a new timeline point locally with the files that are located at the stage. After each commit, local repository is ahead of server repository by 1 point.

5.4. git push

Uploads the changes in the local timeline to the server repository. This effectively synchronises the server repository to the local one in the current branch.

5.5. git pull

Obtains updates from the repository to the current branch if the timeline of the server repository is ahead of the local timeline

6. When modifications are committed and pushed and tested at the staging folder

6.1. git checkout <branch name>

Changes to the other branch.

6.2. git merge <branch name>

Merges the branch with name <branch name> into the current branch. Therefore before this command you should use git checkout to change to the target branch.

6.3. Synchronise main repository for master branch with the website main folder repository.
