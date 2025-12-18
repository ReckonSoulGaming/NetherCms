<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests\AlertRequest;
use App\Alert;

class AlertController extends AdminController
{
    public function index()
    {
        return view('manage.admin.alert.index', [
            'alerts' => $this->getAllAlerts(),
        ]);
    }

    public function create()
    {
        return view('manage.admin.alert.addalert', [
            'alerts' => $this->getAllAlerts(),
        ]);
    }

    public function store(AlertRequest $request)
    {
        $isOnStore = $request->seeinstore === 'on';

        $alert = new Alert;

        $alert->alert_tag           = $request->tag;
        $alert->alert_title         = $request->title;
        $alert->alert_content       = $request->content;
        $alert->alert_show_on_store = $isOnStore;
        $alert->alert_views         = 0;

        $alert->save();

        return redirect()
            ->route('alert.index')
            ->with('manageAlertAdded', 'Announcement created.');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
        return view('manage.admin.alert.editalert', [
            'alert' => $this->getAlert($id),
        ]);
    }

    public function update(AlertRequest $request, $id)
    {
        $isOnStore = $request->seeinstore === 'on';

        $alert = Alert::find($id);

        if (!$alert) {
            return redirect()
                ->route('alert.index')
                ->with('alertError', 'Announcement not found.');
        }

        $alert->update([
            'alert_tag'           => $request->tag,
            'alert_title'         => $request->title,
            'alert_content'       => $request->content,
            'alert_show_on_store' => $isOnStore,
        ]);

        return redirect()
            ->route('alert.index')
            ->with('manageAlertUpdated', 'Announcement updated.');
    }

    public function destroy($id)
    {
        $alert = Alert::find($id);

        if (!$alert) {
            return redirect()
                ->route('alert.index')
                ->with('alertError', 'Announcement not found.');
        }

        $alert->delete();

        return redirect()
            ->route('alert.index')
            ->with('manageAlertRemoved', 'Announcement deleted.');
    }

    /**
     * Internal update (AJAX-less panel form)
     */
    public function doUpdate(Request $request)
    {
        $request->validate([
            'id'      => 'required|integer',
            'title'   => 'required|string|max:255',
            'content' => 'required|string',
            'tag'     => 'nullable|string|max:100',
        ]);

        $isOnStore = $request->seeinstore === 'on';

        $alert = Alert::find($request->id);

        if (!$alert) {
            return redirect()
                ->route('alert.index')
                ->with('alertError', 'Announcement not found.');
        }

        try {
            $alert->update([
                'alert_tag'           => $request->tag,
                'alert_title'         => $request->title,
                'alert_content'       => $request->content,
                'alert_show_on_store' => $isOnStore,
            ]);
        } catch (\Throwable $e) {
            return redirect()
                ->route('alert.index')
                ->with('alertError', 'Failed to update announcement.');
        }

        return redirect()
            ->route('alert.index')
            ->with('manageAlertUpdated', 'Announcement updated.');
    }

    /**
     * Internal delete (AJAX-less)
     */
    public function doDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
        ]);

        $alert = Alert::find($request->id);

        if (!$alert) {
            return redirect()
                ->route('alert.index')
                ->with('alertError', 'Announcement not found.');
        }

        try {
            $alert->delete();
        } catch (\Throwable $e) {
            return redirect()
                ->route('alert.index')
                ->with('alertError', 'Failed to delete announcement.');
        }

        return redirect()
            ->route('alert.index')
            ->with('manageAlertRemoved', 'Announcement deleted.');
    }
}
