import Axios from 'axios'

const axios = Axios.create({
    baseURL: process.env.SERVER_SERVER_URL ?? 'http://localhost:8008',
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
        'Accept': 'application/json',
        'Content-Type': 'application/json'
    },
    withCredentials: true,
})

export default axios