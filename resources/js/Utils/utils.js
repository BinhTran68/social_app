import axios from "axios";
import {CLOUDINARY_NAME} from "@/Utils/Constant.js";

export const formatDate = (value, formatting = { month: 'short', day: 'numeric', year: 'numeric', hour: 'numeric', minute: 'numeric' }) => {
    if (!value) return value
    return new Date(value).toLocaleDateString(
        'vi-VN',
        formatting
    )
}
export const uploadFileToCloud = (formData, folder_name) => {
    return axios.post(`https://api.cloudinary.com/v1_1/${CLOUDINARY_NAME}/image/upload?folder=${folder_name}`, formData)
        .then((response) => {
            return response.data.secure_url
        }).catch(e => {
            console.log(e)
            return null
        })
}
export  const isImage = (image)  => {
    const  mime = image.type.split('/')
    return mime[0].toLowerCase() === 'image'
}
