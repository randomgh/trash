import { Router } from 'express';
import multer from 'multer';
import path from 'path';
import dotenv from 'dotenv';

import { channels } from '../controllers';

dotenv.config();

const router = new Router(),
      upload = multer({ dest: path.resolve(__dirname, `../..${process.env.UPLOADS_DIR}/channels`) });

router.post('/', upload.single('image'), channels.create);
router.get('/', channels.getAll);
router.put('/', upload.single('image'), channels.update);
router.delete('/', channels.delete);

router.get('/:_id', channels.getOne);
router.put('/:_id', upload.single('image'), channels.update);
router.delete('/:_id', channels.delete);

export default router;