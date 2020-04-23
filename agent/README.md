# ARP Agent

This folder contains the code for an example ARP agent, which features a library to connect to the ARP api.

The development of the agent can be performed using vscode and the associated `.devcontainer.json` to ensure you have all the appropriate build environment.

Once you have built an agent with its respective logic, you can use the accompanying docker file to build an image for the agent. This enables the code to be run on any desktop (Linux, Mac and Windows) and just needs the appropriate environment variables and usb port to be parsed through.

Using docker containers also enables us to deploy agents in the cloud and while we won't be printing with them, it gives us a unique ability to simulate various combinations of agents connecting to the service and mimicing the behaviour of 3D printing.