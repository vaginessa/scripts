from fabric.api import env, run, sudo

env.hosts = ['root@vm1', 'root@vm2]

def update_vm():
    sudo('aptitude -y safe-upgrade')
