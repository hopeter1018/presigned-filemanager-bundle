<?php

/*
 * <hokwaichi@gmail.com>
 */

declare(strict_types=1);

namespace HoPeter1018\PresignedFilemanagerBundle;

final class Events
{
    const MANAGER_BEFORE_LIST_SANITIZE = 'presigned_filemanager.manager.before_list_sanitize';

    const MANAGER_AFTER_LIST_SANITIZE = 'presigned_filemanager.manager.after_list_sanitize';

    const MANAGER_BEFORE_LIST = 'presigned_filemanager.manager.before_list';

    const MANAGER_AFTER_LIST = 'presigned_filemanager.manager.after_list';

    const MANAGER_BEFORE_REMOVE_SANITIZE = 'presigned_filemanager.manager.before_remove_sanitize';

    const MANAGER_AFTER_REMOVE_SANITIZE = 'presigned_filemanager.manager.after_remove_sanitize';

    const MANAGER_BEFORE_REMOVE = 'presigned_filemanager.manager.before_remove';

    const MANAGER_AFTER_REMOVE = 'presigned_filemanager.manager.after_remove';

    const MANAGER_BEFORE_PRESIGN_SANITIZE = 'presigned_filemanager.manager.before_presign_sanitize';

    const MANAGER_AFTER_PRESIGN_SANITIZE = 'presigned_filemanager.manager.after_presign_sanitize';

    const MANAGER_BEFORE_PRESIGN = 'presigned_filemanager.manager.before_presign';

    const MANAGER_AFTER_PRESIGN = 'presigned_filemanager.manager.after_presign';

    const MANAGER_BEFORE_UPLOADED_SANITIZE = 'presigned_filemanager.manager.before_uploaded_sanitize';

    const MANAGER_AFTER_UPLOADED_SANITIZE = 'presigned_filemanager.manager.after_uploaded_sanitize';

    const MANAGER_BEFORE_UPLOADED = 'presigned_filemanager.manager.before_uploaded';

    const MANAGER_AFTER_UPLOADED = 'presigned_filemanager.manager.after_uploaded';
}
