import { ArpSDK } from './lib/ArpSDK'
import dotenv from 'dotenv'
import SerialPort from 'serialport'

// check for a local .env file
dotenv.config()

// A puse function to simulate printing time
const wait = (ms: number) => new Promise((r, j) => setTimeout(r, ms))

// Send a command through usb
const sendCmd = (lines: String[], n: number, usbPort: SerialPort) => {
	n++
	// check if it a comment
	let cmd = lines[n].split(';')[0]
	// If cmd then send through
	if (cmd) {
		console.log(n, cmd)
		cmd += '\r\n'
		usbPort.write(cmd)
	} else {
		// else send the next line
		sendCmd(lines, n, usbPort)
	}
}

const main = async () => {
	const api = new ArpSDK(
		process.env.ARP_PRINTER_ID || process.exit(),
		process.env.ARP_URI || process.exit()
	)

	// Example work flow

	// Say I am Online
	console.log('Setting status to online')
	let res = await api.updatePrinterStatus('Online')
	console.log(res)

	// Get my prints
	console.log('Checking for prints that I have assigned to myself')
	let prints = await api.getSelectedPrints()
	console.log(prints)

	if (prints.length == 0) {
		// Get queued prints
		console.log('Getting prints from main queue')
		prints = await api.getQueuedPrints()
		console.log(prints)

		// Select the first print
		console.log('Selecting first print')
		res = await api.selectPrint(prints[0].print_id)
		console.log(res)
	}

	// get the gcode of my print
	console.log('Retrieving gcode')
	const gcode = await api.getGCode(prints[0].print_id)
	console.log(gcode.length)

	console.log('Setting status to printing')
	res = await api.updatePrinterStatus('Printing')
	console.log(res)

	// ###########
	// Connection to print and sending of print data
	await wait(2000)

	/*
	let n = -1
	let lines = gcode.split('\n')
	const usbPort = new SerialPort(
		process.env.ARP_USB_PORT || process.exit(),
		{
			baud_rate: process.env.ARP_BAUD_RATE || process.exit()
		}
	)
	const parser = usbPort.pipe(new Readline({ delimiter: '\n' }))

	parser.on('data', (data) => {
		console.log('Data received: '+data);
		if (data.includes('ok')) {
			sendCmd(lines, n, usbPort);
		}
	});
	*/

	console.log('Print complete')
	res = await api.printComplete(prints[0].print_id)
	console.log(res)

	// Imagine I have completed the print
	console.log('Going offline')
	res = await api.updatePrinterStatus('Offline')
	console.log(res)

	// Ping message to user to say print is complete
	// User retrieves components and starts the process again
}

main()
